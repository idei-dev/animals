# Arquitectura de Servicios, Controladores de Recursos y Control de Acceso por Roles en Laravel

**Carrera:** Tecnicatura Universitaria en Programación Web  
**Materia:** Programación Web Avanzada / Taller de Desarrollo Web  
**Clase:** 12 – Módulo de Gestión de Usuarios y Seguridad  
**Repositorio de la Cátedra:** `https://github.com/idei-dev/animals`

---

## Planificación y Dinámica Git de la Clase

Para garantizar una sesión fluida y sin tropiezos técnicos, seguiremos esta estrategia de ramas:

```
[ Rama 'main' ] ──────────┬─────────────────────────────► [ Merge post-clase ] ──► (Alumnos hacen git pull)
                          │                                      ▲
                          ▼                                      │
                 [ Rama 'clase12' ] ──(Live-coding en vivo)──────┘
                          
[ Rama 'clase12-diseño' ] ──► (Tu copia de seguridad de respaldo con el código funcional)
```

1. **Antes de la clase:** Guardas el estado funcional actual en el branch `clase12-diseño` como red de seguridad.
2. **Durante la clase (Demostración en vivo):** Creas el branch `clase12` a partir de `main` y codificas paso a paso frente a los alumnos.
3. **Al finalizar la demostración:** Mergeas `clase12` en `main` y haces `git push`.
4. **Laboratorio de los alumnos (Sprint de 2 horas):** Los alumnos clonan/actualizan `main` y completan el CRUD de usuarios tomando como referencia el módulo existente de especies (`species`).

# PARTE 1: Demostración

```
                       ARQUITECTURA DE LA APLICACIÓN
                       
 [ HTTP Request ] ──► [ Middleware: auth ] ──► [ Middleware: role:admin ]
                                                       │
                                                       ▼
 [ Vista Blade ] ◄─── [ UserController ] ◄─── [ UserServiceInterface ]
                                                       │ (Resuelto por IoC)
                                                       ▼
                                            [ SQLiteUserService ]
                                                       │ (Query Builder)
                                                       ▼
                                              [ DB: SQLite users ]
```

---

### Paso 1: Extensión de la Migración de Usuarios

#### 💡 Marco Teórico para la Clase
> **¿Por qué migraciones y por qué tipos Enum?**  
> Las migraciones permiten versionar la estructura de la base de datos como código fuente (IaC - Infrastructure as Code). Al agregar roles mediante un `enum`, delegamos la integridad de datos al motor relacional: solo permitimos valores finitos y seguros (`admin`, `employee`, `customer`), impidiendo que valores arbitrarios corrompan el esquema de autorización.

#### 🛠️ Archivo: `database/migrations/0001_01_01_000000_create_users_table.php`

Modificamos el esquema agregando los campos `role`, `profile_picture` y `phone_number`:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    
    // Modificaciones para el sistema de roles y perfil:
    $table->enum('role', ['admin', 'employee', 'customer'])->default('customer');
    $table->string('profile_picture')->nullable();
    $table->string('phone_number')->nullable();
    
    $table->timestamps();
});
```

---

### Paso 2: El Contrato de Servicio (`UserServiceInterface`)

#### 💡 Marco Teórico para la Clase
> **El Principio de Inversión de Dependencias (D de SOLID):**  
> Los controladores de nuestra aplicación no deben acoplarse rígidamente a cómo se guardan los datos (SQLite, MySQL, una API externa o un Mock en memoria). Definimos una **Interfaz (Contrato)** que establece el comportamiento esperado. El controlador dependerá de esta abstracción, garantizando bajo acoplamiento y alta capacidad de testeo.

#### 🛠️ Archivo: `app/Contracts/UserServiceInterface.php`

```php
<?php

namespace App\Contracts;

interface UserServiceInterface
{
    public function all(): array;

    public function find(string $id): ?array;

    public function create(array $data): array;

    public function update(string $id, array $data): ?array;

    public function delete(string $id): bool;

    public function reset(): void;
}
```

---

### Paso 3: Implementación para SQLite (`SQLiteUserService`)

#### 💡 Marco Teórico para la Clase
> **Separación de Responsabilidades y Capa de Datos:**  
> Esta clase implementa el contrato utilizando el `Query Builder` (`DB::table`) para optimizar consultas directas en SQLite. Destacar a los alumnos:
> 1. Retornamos arreglos (`array`) en lugar de modelos pesados para desacoplar la vista de Eloquent.
> 2. Manejamos particularidades del motor, como reiniciar la secuencia autoincremental de SQLite (`sqlite_sequence`) en el método `reset()`.

#### 🛠️ Archivo: `app/Services/SQLiteUserService.php`

```php
<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteUserService implements UserServiceInterface
{
    protected string $table = 'users';

    public function all(): array
    {
        return DB::table($this->table)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn ($item) => (array) $item)
            ->toArray();
    }

    public function find(string $id): ?array
    {
        $user = DB::table($this->table)->where('id', $id)->first();

        return $user ? (array) $user : null;
    }

    public function create(array $data): array
    {
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $id = DB::table($this->table)->insertGetId($data);

        return $this->find((string) $id);
    }

    public function update(string $id, array $data): ?array
    {
        $data['updated_at'] = now();
        $updated = DB::table($this->table)->where('id', $id)->update($data);

        return $updated ? $this->find($id) : null;
    }

    public function delete(string $id): bool
    {
        return DB::table($this->table)->where('id', $id)->delete() > 0;
    }

    public function reset(): void
    {
        DB::table($this->table)->delete();
        DB::statement(
            "DELETE FROM sqlite_sequence WHERE name='{$this->table}'"
        );
    }
}
```

---

### Paso 4: Vinculación en el Contenedor de Inversión de Control (`AppServiceProvider`)

#### 💡 Marco Teórico para la Clase
> **Enlazado de Dependencias (Service Binding):**  
> Registramos en el Service Provider la asociación entre la interfaz y su implementación concreta. Usamos `singleton` para que Laravel mantenga una única instancia compartida durante el ciclo de vida de la petición.

#### 🛠️ Archivo: `app/Providers/AppServiceProvider.php`

```php
namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Services\SQLiteUserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            UserServiceInterface::class,
            SQLiteUserService::class
        );

        // ... bindings preexistentes (AnimalServiceInterface, SpeciesServiceInterface)
    }
}
```

---

### Paso 5: Sembrado de Datos (`UserSeeder` y `DatabaseSeeder`)

#### 💡 Marco Teórico para la Clase
> **Consistencia en la Arquitectura:**  
> Notar que el Seeder tampoco interactúa directamente con la base de datos ni con sentencias SQL crudas: inyecta `UserServiceInterface` en su constructor, demostrando que toda la aplicación respeta la misma capa de servicio.

#### 🛠️ Archivo: `database/seeders/UserSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Contracts\UserServiceInterface;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    public function run(): void
    {
        $defaultUsers = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'John Doe', 'email' => 'john.doe@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com'],
        ];

        $this->userService->reset();

        foreach ($defaultUsers as $user) {
            $user['password'] = bcrypt('11111111');
            if (! isset($user['role'])) {
                $user['role'] = 'customer';
            }
            $this->userService->create($user);
        }
    }
}
```

Registramos el seeder en `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        SpeciesSeeder::class,
        AnimalSeeder::class,
    ]);
}
```

*(Opcional pedagógico: En `resources/views/auth/login.blade.php` dejamos precargado `admin@example.com` y `11111111` para agilizar las pruebas en el navegador).*

---

### Paso 6: Creación del Controlador de Recursos (`UserController`)

#### 💻 Ejecución en Consola
Explicar a los alumnos que el flag `-r` (o `--resource`) genera de antemano los 7 métodos del estándar REST:
```bash
php artisan make:controller -r UserController
```

#### 💡 Marco Teórico para la Clase
> **Inyección por Constructor de PHP 8 (Constructor Promotion):**  
> Al escribir `public function __construct(protected UserServiceInterface $userService) {}`, PHP declara el atributo y le asigna el valor inyectado por Laravel en un solo paso, eliminando código repetitivo.

#### 🛠️ Archivo: `app/Http/Controllers/UserController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    /**
     * Muestra el listado de recursos.
     */
    public function index()
    {
        $users = $this->userService->all();

        return view('users.index', compact('users'));
    }

    public function create() { /* Tarea de laboratorio */ }
    public function store(Request $request) { /* Tarea de laboratorio */ }
    public function show(string $id) { /* Tarea de laboratorio */ }
    public function edit(string $id) { /* Tarea de laboratorio */ }
    public function update(Request $request, string $id) { /* Tarea de laboratorio */ }
    public function destroy(string $id) { /* Tarea de laboratorio */ }
}
```

---

### Paso 7: La Vista del Listado (`resources/views/users/index.blade.php`)

#### 💡 Marco Teórico para la Clase
> **Sintaxis de Plantillas Blade:**  
> 1. `<x-app-layout>`: Componente contenedor que hereda estilos globales y el menú de navegación.
> 2. `$item['name']`: Nótese el acceso mediante corchetes de array (y no `$item->name`), ya que nuestro servicio desacoplado entrega arreglos puros.
> 3. `@forelse ... @empty`: Manejo limpio de estados vacíos sin anidar condicionales `@if` dentro de `@foreach`.

#### 🛠️ Archivo: `resources/views/users/index.blade.php`

```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Listado de Usuarios
        </h2>
    </x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <!-- NOTA PARA ALUMNOS: Este botón requiere corrección en el laboratorio -->
        <a href="{{ route('species.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
            + Nuevo Usuario
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/60 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 text-xs uppercase font-semibold text-gray-500 dark:text-slate-400 tracking-wider">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Nombre</th>
                    <th class="py-3 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-sm">
                @forelse ($users as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500 dark:text-slate-400">#{{ $item['id'] }}</td>
                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-slate-100">
                            <a href="{{ route('users.show', $item['id']) }}" class="hover:underline text-indigo-600 dark:text-indigo-400">
                                {{ $item['name'] }}
                            </a>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('users.edit', $item['id']) }}" class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Editar</a>
                                <span class="text-gray-300 dark:text-slate-600">|</span>
                                <form action="{{ route('users.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 dark:text-rose-400 font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center text-gray-500 dark:text-slate-400">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
```

---

### Paso 8: Control de Acceso: El Middleware (`EnsureUserHasRole`)

#### 💡 Marco Teórico para la Clase
> **Autenticación vs. Autorización y el Pipeline HTTP:**  
> - **Autenticación (`auth`):** Valida la identidad del usuario (*"¿Quién sos?"*). Si es anónimo, se le redirige al login con código `302`.
> - **Autorización (`EnsureUserHasRole`):** Valida los permisos del usuario (*"¿Podés entrar acá?"*). Si el usuario no tiene el rol necesario, se frena la petición de inmediato con `abort(403)` (*HTTP 403 Forbidden*).
> 
> Explicar dos sintaxis modernas de PHP utilizadas:
> 1. `$request->user()?->role`: El *Nullsafe Operator* evita un error fatal si el usuario no existe.
> 2. `string ...$roles`: Parámetro variádico que permite recibir múltiples roles permitidos separados por coma (ej: `role:admin,employee`).

#### 🛠️ 1. Archivo: `app/Http/Middleware/EnsureUserHasRole.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! in_array($request->user()?->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
```

#### 🛠️ 2. Registrar el Alias en `bootstrap/app.php`
En las versiones modernas de Laravel (11+), los middlewares ya no se configuran en `Kernel.php`, sino en `bootstrap/app.php` a través del callback `withMiddleware`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\EnsureUserHasRole::class,
    ]);
})
```

---

### Paso 9: Enrutamiento Resource y Blindaje (`routes/web.php`)

#### 💡 Marco Teórico para la Clase
> Al envolver `Route::resource` dentro del grupo de middlewares `['auth', 'role:admin']`, garantizamos que ninguna de las 7 acciones del CRUD sea accesible por usuarios anónimos ni por usuarios con rol `customer` o `employee`.

#### 🛠️ Archivo: `routes/web.php`

```php
use App\Http\Controllers\UserController;

Route::middleware(['auth', 'role:admin'])->resource('/users', UserController::class);
```

---

### Paso 10: Demostración Práctica en Vivo

Ejecutar en la terminal del aula:
```bash
# 1. Refrescar la base de datos y ejecutar los seeders
php artisan migrate:fresh --seed

# 2. Levantar el servidor local
php artisan serve
```

**Pruebas frente a los alumnos:**
1. **Acceso anónimo:** Entrar a `http://localhost:8000/users` en una ventana de incógnito.  
   ➔ *Resultado:* Redirige automáticamente a `/login` (gracias a `auth`).
2. **Acceso como cliente:** Iniciar sesión con `john.doe@example.com` (password `11111111`) e ingresar a `/users`.  
   ➔ *Resultado:* Pantalla de error **403 | This action is unauthorized** (gracias a `role:admin`).
3. **Acceso como administrador:** Iniciar sesión con `admin@example.com` (password `11111111`) e ingresar a `/users`.  
   ➔ *Resultado:* Carga exitosa del listado de usuarios con código **200 OK**.

# PARTE 2: Consigna de Laboratorio

> ### ⏱️ Duración: 2 Horas reloj
> **Modalidad:** Individual / Presencial en Máquina  
> **Objetivo:** Completar el flujo CRUD de usuarios replicando la arquitectura de servicios y las vistas Blade ya existentes en el proyecto.

### 📋 Instrucciones Iniciales de Git
1. Abrir la terminal y sincronizar la rama `main` del repositorio oficial:
   ```bash
   git pull origin main
   ```
2. Ejecutar las migraciones y seeders para asegurar el entorno limpio:
   ```bash
   php artisan migrate:fresh --seed
   ```

### 🎯 Tareas Obligatorias a Completar

#### 1. Corrección en la Vista `resources/views/users/index.blade.php`
- Localizar el botón `+ Nuevo Usuario` y corregir su ruta para que apunte a `route('users.create')`.

#### 2. Implementar los Métodos en `UserController`
Tomando como referencia el archivo `app/Http/Controllers/SpeciesController.php`, completar:
- `create()`: Retornar la vista `users.create`.
- `store(Request $request)`: Validar campos (`name`, `email`, `password`, `role`), hashear la contraseña (`bcrypt` o `Hash::make`), invocar `$this->userService->create($data)` y redirigir con mensaje de éxito a `users.index`.
- `show(string $id)`: Buscar el usuario mediante el servicio, validar con `abort_if(! $user, 404)` y retornar `users.show`.
- `edit(string $id)`: Buscar el usuario y retornar la vista `users.edit`.
- `update(Request $request, string $id)`: Validar datos, invocar `$this->userService->update($id, $data)` y redirigir con mensaje de éxito.
- `destroy(string $id)`: Invocar `$this->userService->delete($id)` y redirigir a `users.index`.

#### 3. Crear las Vistas Blade Faltantes
En la carpeta `resources/views/users/`, crear los archivos basándose en las vistas de `species` o `animals`:
- `create.blade.php`: Formulario con `POST` para `users.store` con campos: Nombre, Email, Password y Selector de Rol (`admin`, `employee`, `customer`).
- `edit.blade.php`: Formulario con directiva `@method('PUT')` para actualizar datos.
- `show.blade.php`: Ficha de detalle del usuario seleccionado.

### ✅ Criterios de Aceptación para la Entrega (Checklist de Evaluación)
- [ ] No se pueden romper las reglas de autorización: sólo los usuarios con rol `admin` deben poder ingresar al módulo `/users`.
- [ ] Todas las vistas deben extender de `<x-app-layout>`.
- [ ] Los datos se deben manipular siempre a través de `UserServiceInterface` (sin llamadas directas a modelos Eloquent en el controlador).
- [ ] Se debe mostrar el mensaje de confirmación (`session('success')`) al crear, editar o eliminar.

