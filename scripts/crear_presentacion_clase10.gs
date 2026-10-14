/**
 * Crea en Google Slides una presentación didáctica de exactamente 30 diapositivas
 * sobre la continuación del proyecto Animals & Species.
 *
 * Ejecución: abrir script.google.com, pegar este archivo en un proyecto Apps
 * Script vinculado o independiente y ejecutar crearPresentacionClase10Animals.
 */
function crearPresentacionClase10Animals() {
  const slides = obtenerContenidoClase10Animals_();
  if (slides.length !== 30) {
    throw new Error('La presentación debe contener exactamente 30 diapositivas.');
  }

  const presentation = SlidesApp.create(
    'Desarrollo Backend I - Clase 10 - Animals & Species'
  );
  const existingSlides = presentation.getSlides();
  const firstSlide = existingSlides[0];

  for (let index = existingSlides.length - 1; index > 0; index -= 1) {
    existingSlides[index].remove();
  }

  firstSlide.getPageElements().forEach(function (element) {
    element.remove();
  });

  slides.forEach(function (slideData, index) {
    const slide = index === 0
      ? firstSlide
      : presentation.appendSlide(SlidesApp.PredefinedLayout.BLANK);

    dibujarDiapositivaClase10_(slide, slideData, index + 1, slides.length, presentation);
  });

  const createdSlides = presentation.getSlides();
  if (createdSlides.length !== 30) {
    throw new Error(
      'La presentación se creó con ' + createdSlides.length +
      ' diapositivas; se esperaban exactamente 30.'
    );
  }

  Logger.log('Presentación creada: ' + presentation.getUrl());
  return presentation.getUrl();
}

function dibujarDiapositivaClase10_(slide, data, slideNumber, totalSlides, presentation) {
  const width = presentation.getPageWidth();
  const height = presentation.getPageHeight();
  const colors = {
    background: '#1E293B',
    code: '#0F172A',
    white: '#F8FAFC',
    muted: '#CBD5E1',
    secondary: '#94A3B8',
    emerald: '#10B981',
    cyan: '#06B6D4',
    codeGreen: '#4ADE80',
    codeCyan: '#67E8F9',
    panel: '#263449'
  };
  const accent = data.accent === 'cyan' ? colors.cyan : colors.emerald;

  slide.getBackground().setSolidFill(colors.background);

  if (data.layout === 'cover') {
    dibujarPortadaClase10_(slide, data, width, height, colors);
    return;
  }

  insertarTextoClase10_(
    slide,
    data.section.toUpperCase(),
    34,
    18,
    width - 100,
    15,
    10,
    accent,
    true,
    'Arial'
  );
  insertarTextoClase10_(
    slide,
    data.title,
    34,
    36,
    width - 70,
    48,
    data.title.length > 48 ? 23 : 27,
    colors.white,
    true,
    'Arial'
  );
  insertarTextoClase10_(
    slide,
    data.lead,
    34,
    86,
    width - 70,
    35,
    14,
    colors.muted,
    false,
    'Arial'
  );

  if (data.layout === 'flow') {
    dibujarFlujoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'code') {
    dibujarCodigoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'wideCode') {
    dibujarCodigoAnchoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'compare') {
    dibujarComparacionClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'quiz') {
    dibujarPreguntaClase10_(slide, data, width, colors, accent);
  } else {
    dibujarDosPanelesClase10_(slide, data, width, colors, accent);
  }

  dibujarCierreClase10_(slide, data.takeaway, slideNumber, totalSlides, width, height, colors, accent);
}

function dibujarPortadaClase10_(slide, data, width, height, colors) {
  slide.getBackground().setSolidFill(colors.background);
  dibujarRectanguloClase10_(slide, 36, 35, 8, 282, colors.emerald);
  insertarTextoClase10_(slide, 'DESARROLLO BACKEND I  /  TUPW', 66, 40, width - 110, 20, 12, colors.cyan, true, 'Arial');
  insertarTextoClase10_(slide, data.title, 66, 86, width - 130, 98, 38, colors.white, true, 'Arial');
  insertarTextoClase10_(slide, data.lead, 68, 190, width - 145, 54, 18, colors.muted, false, 'Arial');

  const cardY = 278;
  const cardWidth = (width - 116) / 3;
  data.cards.forEach(function (card, index) {
    const x = 36 + index * (cardWidth + 22);
    dibujarTarjetaClase10_(slide, x, cardY, cardWidth, 74, colors.panel);
    insertarTextoClase10_(slide, card, x + 14, cardY + 13, cardWidth - 28, 52, 13, colors.white, true, 'Arial');
  });

  insertarTextoClase10_(slide, 'CLASE 10  ·  CONTINUACIÓN DEL PROYECTO ANIMALS & SPECIES', 38, height - 27, width - 76, 15, 9, colors.secondary, false, 'Arial');
}

function dibujarDosPanelesClase10_(slide, data, width, colors, accent) {
  const gap = 18;
  const margin = 34;
  const panelWidth = (width - margin * 2 - gap) / 2;
  const top = 130;
  const panelHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, panelWidth, panelHeight, colors.panel);
  dibujarTarjetaClase10_(slide, margin + panelWidth + gap, top, panelWidth, panelHeight, colors.panel);
  insertarTextoClase10_(slide, data.leftTitle || 'ENFOQUE', margin + 14, top + 12, panelWidth - 28, 20, 12, accent, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.left || []), margin + 14, top + 40, panelWidth - 28, panelHeight - 50, 14, colors.muted, false, 'Arial');

  const rightX = margin + panelWidth + gap;
  insertarTextoClase10_(slide, data.rightTitle || 'PARA COMPROBAR', rightX + 14, top + 12, panelWidth - 28, 20, 12, colors.cyan, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.right || []), rightX + 14, top + 40, panelWidth - 28, panelHeight - 50, 14, colors.muted, false, 'Arial');
}

function dibujarCodigoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const codeWidth = width * 0.62;
  const rightX = margin + codeWidth + 16;
  const rightWidth = width - rightX - margin;
  const top = 130;
  const panelHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, codeWidth, panelHeight, colors.code);
  insertarTextoClase10_(slide, data.codeTitle || 'FRAGMENTO DEL PROYECTO', margin + 14, top + 10, codeWidth - 28, 17, 10, accent, true, 'Arial');
  insertarTextoClase10_(slide, data.code, margin + 14, top + 34, codeWidth - 28, panelHeight - 43, data.codeSize || 12, colors.codeGreen, false, 'Courier New');

  dibujarTarjetaClase10_(slide, rightX, top, rightWidth, panelHeight, colors.panel);
  insertarTextoClase10_(slide, data.rightTitle || 'LECTURA GUIADA', rightX + 13, top + 12, rightWidth - 26, 20, 11, colors.cyan, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.right || []), rightX + 13, top + 40, rightWidth - 26, panelHeight - 50, 13, colors.muted, false, 'Arial');
}

function dibujarCodigoAnchoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const panelWidth = width - margin * 2;
  dibujarTarjetaClase10_(slide, margin, 130, panelWidth, 155, colors.code);
  insertarTextoClase10_(slide, data.codeTitle || 'REGLA REAL DE VALIDACIÓN', margin + 14, 140, panelWidth - 28, 18, 10, accent, true, 'Arial');
  insertarTextoClase10_(slide, data.code, margin + 14, 165, panelWidth - 28, 105, data.codeSize || 11, colors.codeCyan, false, 'Courier New');
  dibujarTarjetaClase10_(slide, margin, 296, panelWidth, 47, colors.panel);
  insertarTextoClase10_(slide, convertirListaClase10_(data.right || []), margin + 13, 302, panelWidth - 26, 35, 12, colors.muted, false, 'Arial');
}

function dibujarComparacionClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const gap = 18;
  const cardWidth = (width - margin * 2 - gap) / 2;
  const top = 130;
  const cardHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, cardWidth, cardHeight, colors.panel);
  dibujarTarjetaClase10_(slide, margin + cardWidth + gap, top, cardWidth, cardHeight, colors.panel);
  insertarTextoClase10_(slide, data.leftTitle, margin + 14, top + 12, cardWidth - 28, 22, 13, accent, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.left || []), margin + 14, top + 44, cardWidth - 28, cardHeight - 55, 14, colors.muted, false, 'Arial');
  const rightX = margin + cardWidth + gap;
  insertarTextoClase10_(slide, data.rightTitle, rightX + 14, top + 12, cardWidth - 28, 22, 13, colors.cyan, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.right || []), rightX + 14, top + 44, cardWidth - 28, cardHeight - 55, 14, colors.muted, false, 'Arial');
}

function dibujarFlujoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const gap = 10;
  const cardWidth = (width - margin * 2 - gap * (data.steps.length - 1)) / data.steps.length;
  const top = 158;

  data.steps.forEach(function (step, index) {
    const x = margin + index * (cardWidth + gap);
    dibujarTarjetaClase10_(slide, x, top, cardWidth, 115, colors.panel);
    insertarTextoClase10_(slide, '0' + (index + 1), x + 12, top + 11, cardWidth - 24, 17, 11, accent, true, 'Arial');
    insertarTextoClase10_(slide, step, x + 12, top + 37, cardWidth - 24, 67, 13, colors.white, true, 'Arial');
  });

  insertarTextoClase10_(slide, data.flowNote || '', margin, 292, width - margin * 2, 43, 15, colors.muted, false, 'Arial');
}

function dibujarPreguntaClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  dibujarTarjetaClase10_(slide, margin, 132, width - margin * 2, 205, colors.panel);
  insertarTextoClase10_(slide, data.prompt, margin + 22, 150, width - margin * 2 - 44, 61, 21, colors.white, true, 'Arial');
  insertarTextoClase10_(slide, convertirListaClase10_(data.options || []), margin + 24, 225, width - margin * 2 - 48, 85, 15, colors.muted, false, 'Arial');
  insertarTextoClase10_(slide, 'PREDICE  →  PRUEBA  →  EXPLICA', margin + 22, 311, width - margin * 2 - 44, 17, 10, accent, true, 'Arial');
}

function dibujarCierreClase10_(slide, takeaway, slideNumber, totalSlides, width, height, colors, accent) {
  dibujarRectanguloClase10_(slide, 34, height - 43, width - 68, 1.5, accent);
  insertarTextoClase10_(slide, takeaway, 34, height - 39, width - 170, 19, 10, colors.white, true, 'Arial');
  insertarTextoClase10_(slide, slideNumber + ' / ' + totalSlides, width - 90, height - 39, 56, 19, 10, colors.secondary, false, 'Arial');
}

function dibujarTarjetaClase10_(slide, x, y, width, height, fill) {
  const shape = slide.insertShape(SlidesApp.ShapeType.ROUND_RECTANGLE, x, y, width, height);
  shape.getFill().setSolidFill(fill);
}

function dibujarRectanguloClase10_(slide, x, y, width, height, fill) {
  const shape = slide.insertShape(SlidesApp.ShapeType.RECTANGLE, x, y, width, height);
  shape.getFill().setSolidFill(fill);
}

function insertarTextoClase10_(slide, text, x, y, width, height, size, color, bold, fontFamily) {
  const box = slide.insertTextBox(text, x, y, width, height);
  box.setContentAlignment(SlidesApp.ContentAlignment.TOP);
  box.getText().getTextStyle()
    .setFontFamily(fontFamily)
    .setFontSize(size)
    .setForegroundColor(color)
    .setBold(bold);
  return box;
}

function convertirListaClase10_(items) {
  return items.map(function (item) {
    return '- ' + item;
  }).join('\n');
}

function obtenerContenidoClase10Animals_() {
  return [
    {
      layout: 'cover',
      title: 'De Species a Animals',
      lead: 'Completar el recorrido CRUD: adaptar Blade, implementar el detalle y hacer visibles los errores de validación.',
      cards: [
        'CLASE 10  |  DESARROLLO BACKEND I',
        'PROYECTO  |  ANIMALS & SPECIES',
        'DURACIÓN  |  120 MINUTOS'
      ],
      takeaway: 'De la reutilización de vistas a una prueba completa y observable.'
    },
    {
      section: 'Propósito y resultados',
      title: '¿Qué podremos hacer al terminar?',
      lead: 'Seguir una petición real desde la interfaz hasta su respuesta y explicar cada decisión.',
      leftTitle: 'RESULTADOS DE APRENDIZAJE',
      left: [
        'Adaptar vistas Blade reutilizadas a un recurso distinto.',
        'Conectar la ruta animals.show con el controlador y la vista.',
        'Predecir y diagnosticar los errores de validación.'
      ],
      rightTitle: 'RITMO DE LOS 120 MINUTOS',
      right: [
        'Apertura y patrón Species: 20 min.',
        'Adaptación de vistas y show: 40 min.',
        'Validación, errores y alta válida: 45 min.',
        'Integración individual y cierre: 15 min.'
      ],
      takeaway: 'La meta es explicar el flujo, no sólo conseguir que “funcione”.',
      accent: 'cyan'
    },
    {
      section: 'Punto de partida',
      title: 'Species ya aporta un patrón reutilizable',
      lead: 'Antes de copiar, observamos qué estructura existe y qué información es propia de cada recurso.',
      leftTitle: 'VISTAS DE SPECIES',
      left: [
        'resources/views/species/index.blade.php',
        'resources/views/species/create.blade.php',
        'resources/views/species/edit.blade.php',
        'resources/views/species/show.blade.php'
      ],
      rightTitle: 'PREGUNTAS PARA LEER',
      right: [
        '¿Qué nombre de ruta usa cada enlace?',
        '¿Qué variable recibe cada vista?',
        '¿Qué campos y acciones pertenecen a la entidad?'
      ],
      takeaway: 'Primero entendemos el patrón; después lo reutilizamos.',
      accent: 'emerald'
    },
    {
      section: 'Punto de partida',
      title: 'Mapa de una petición web',
      lead: 'La vista no resuelve sola la operación: cada capa cumple una responsabilidad.',
      layout: 'flow',
      steps: [
        'Navegador solicita una ruta nombrada.',
        'La ruta dirige la petición al controlador.',
        'El controlador consulta el servicio por datos.',
        'Blade renderiza la respuesta HTML.'
      ],
      flowNote: 'Durante la clase seguiremos este trayecto en index, show y store.',
      takeaway: 'En cada paso preguntamos: ¿qué dato entra y qué resultado sale?',
      accent: 'cyan'
    },
    {
      section: 'Duplicar y adaptar',
      title: 'Duplicar la carpeta en VS Code',
      lead: 'La copia conserva una estructura útil; no garantiza que las referencias sean correctas.',
      leftTitle: 'DEMOSTRACIÓN GUIADA',
      left: [
        'En Explorer, localizar resources/views/species.',
        'Copiar la carpeta y pegarla en views.',
        'Renombrar la copia como animals.',
        'Confirmar que estén las cuatro vistas.'
      ],
      rightTitle: 'PAUSA DE CONTROL',
      right: [
        'Verificar la ruta resources/views/animals.',
        'Comparar el inventario de archivos.',
        'No reemplazar todo el proyecto ni tocar rutas ajenas.'
      ],
      takeaway: 'Duplicar archivos es el comienzo, no el final de la adaptación.',
      accent: 'emerald'
    },
    {
      section: 'Duplicar y adaptar',
      title: 'Inventario: una vista, una responsabilidad',
      lead: 'Relacionamos cada plantilla con la operación que presentará.',
      layout: 'compare',
      leftTitle: 'LISTA Y FORMULARIOS',
      left: [
        'index: muestra registros y acciones.',
        'create: presenta el alta.',
        'edit: carga y actualiza un registro.'
      ],
      rightTitle: 'DETALLE Y DATOS',
      right: [
        'show: presenta un animal individual.',
        'Animals incluye name, species y age.',
        'Cada plantilla debe recibir datos con la forma esperada.'
      ],
      takeaway: 'Comprueba variables, campos y acciones en cada archivo.',
      accent: 'cyan'
    },
    {
      section: 'Duplicar y adaptar',
      title: 'Buscar referencias antes de editar',
      lead: 'La búsqueda de VS Code ayuda a encontrar los nombres heredados de Species.',
      leftTitle: 'TÉRMINOS A REVISAR',
      left: [
        'species y Species en textos y rutas.',
        'species.index y species.show son nombres de ruta.',
        '$species frente a $animal o $animals.',
        'Etiquetas, mensajes y acciones.'
      ],
      rightTitle: 'MÉTODO SEGURO',
      right: [
        'Abrir cada coincidencia en contexto.',
        'Decidir si es una referencia a ruta, dato o dominio.',
        'Editar y volver a buscar.',
        'Comparar la vista con su controlador.'
      ],
      takeaway: 'Búsqueda contextual antes que reemplazo ciego.',
      accent: 'emerald'
    },
    {
      section: 'Duplicar y adaptar',
      title: 'No todo “species” se cambia igual',
      lead: 'El recurso Animal contiene una propiedad species: algunas coincidencias deben permanecer.',
      layout: 'compare',
      leftTitle: 'CAMBIAR A ANIMALS',
      left: [
        'Nombres de rutas: animals.index, animals.store.',
        'Carpeta y textos del recurso.',
        'Variables del listado: $animals.'
      ],
      rightTitle: 'CONSERVAR O REVISAR',
      right: [
        'El campo animals.species describe la clasificación.',
        'La ruta species.index sigue siendo válida.',
        'Comprobar cada coincidencia semánticamente.'
      ],
      takeaway: 'Las palabras parecidas pueden representar conceptos diferentes.',
      accent: 'cyan'
    },
    {
      section: 'Vistas Blade',
      title: 'Index: del dato al enlace de detalle',
      lead: 'El listado recorre animales y enlaza cada registro mediante su identificador.',
      layout: 'code',
      codeTitle: 'resources/views/animals/index.blade.php',
      code: "@forelse ($animals as $item)\n    <a href=\"{{ route('animals.show', $item['id']) }}\">\n        {{ $item['name'] }}\n    </a>\n    {{ $item['species'] }}\n    {{ $item['age'] }}\n@empty\n    No hay animales registrados.\n@endforelse",
      rightTitle: 'LECTURA GUIADA',
      right: [
        '$animals es la colección del listado.',
        '$item representa un registro.',
        'La ruta show necesita el ID.',
        'Las llaves dobles escapan la salida.'
      ],
      takeaway: 'Un enlace visible implica que la ruta y la acción deben existir.',
      accent: 'emerald'
    },
    {
      section: 'Vistas Blade',
      title: 'Create: campos y protección del formulario',
      lead: 'El formulario envía los datos a la ruta nombrada que almacena el animal.',
      layout: 'code',
      codeTitle: 'resources/views/animals/create.blade.php',
      code: "<form action=\"{{ route('animals.store') }}\" method=\"POST\">\n    @csrf\n    <input name=\"name\" value=\"{{ old('name') }}\">\n    <input name=\"species\" value=\"{{ old('species') }}\">\n    <input type=\"number\" name=\"age\" value=\"{{ old('age') }}\">\n    <button type=\"submit\">Guardar Animal</button>\n</form>",
      rightTitle: 'PUNTOS DE ATENCIÓN',
      right: [
        'POST envía datos al servidor.',
        '@csrf incorpora el token CSRF.',
        'old() repuebla valores anteriores.',
        'Los nombres deben coincidir con la validación.'
      ],
      takeaway: 'Los nombres de los inputs son parte del contrato del formulario.',
      accent: 'cyan'
    },
    {
      section: 'Vistas Blade',
      title: 'Edit: conservar el valor existente',
      lead: 'En edición, old() usa primero lo reenviado; si no existe, muestra el dato actual.',
      layout: 'code',
      codeTitle: 'resources/views/animals/edit.blade.php',
      code: "<form action=\"{{ route('animals.update', $animal['id']) }}\" method=\"POST\">\n    @csrf\n    @method('PUT')\n    <input name=\"name\"\n        value=\"{{ old('name', $animal['name']) }}\">\n    <input name=\"species\"\n        value=\"{{ old('species', $animal['species']) }}\">\n    <input name=\"age\"\n        value=\"{{ old('age', $animal['age']) }}\">\n</form>",
      rightTitle: 'IDEA CLAVE',
      right: [
        'HTML forms no envían PUT directamente.',
        '@method simula el verbo HTTP esperado.',
        'old(valor, respaldo) mejora la recuperación.',
        'La ruta recibe el ID del animal.'
      ],
      takeaway: 'Distingue el dato actual de la entrada anterior.',
      accent: 'emerald'
    },
    {
      section: 'Rutas y navegación',
      title: 'Route::resource define las rutas CRUD',
      lead: 'El recurso registra nombres convencionales, incluido animals.show.',
      layout: 'code',
      codeTitle: 'routes/web.php',
      code: "Route::resource('/animals', AnimalController::class);\n\nRoute::post('/animals/reset', [AnimalController::class, 'reset'])\n    ->name('animals.reset');",
      rightTitle: 'CONTRATO ESPERADO',
      right: [
        'animals.index: listado.',
        'animals.create / store: formulario y alta.',
        'animals.show: detalle por ID.',
        'animals.edit / update: edición.'
      ],
      takeaway: 'La ruta resource expone el contrato; el controlador implementa las acciones.',
      accent: 'cyan'
    },
    {
      section: 'Detalle del animal',
      title: 'El enlace apunta a una acción todavía faltante',
      lead: 'Un nombre de ruta puede estar disponible antes de que el método esté implementado.',
      layout: 'compare',
      leftTitle: 'EN LA VISTA INDEX',
      left: [
        "route('animals.show', $item['id'])",
        'El ID identifica qué animal solicitar.',
        'El navegador realiza una petición GET.'
      ],
      rightTitle: 'EN EL CONTROLADOR',
      right: [
        'Debe existir show(string $id).',
        'Debe buscar el registro por ese ID.',
        'Debe devolver la vista de detalle.'
      ],
      takeaway: 'Seguimos la referencia desde el enlace hasta su destino.',
      accent: 'emerald'
    },
    {
      section: 'Detalle del animal',
      title: 'Crear la acción show',
      lead: 'La acción consulta el servicio y prepara los datos que recibirá Blade.',
      layout: 'code',
      codeTitle: 'AnimalController.php',
      code: "public function show(string $id)\n{\n    try {\n        $animal = $this->animalService->find($id);\n        return view('animals.show', ['id' => $id, 'animal' => $animal]);\n    } catch (\\Exception $e) {\n        return redirect()->route('animals.index')->with('error', $e->getMessage());\n    }\n}",
      rightTitle: 'SECUENCIA',
      right: [
        '1. Recibir el ID de la ruta.',
        '2. Solicitar el animal por ID.',
        '3. Renderizar animals.show.',
        '4. Entregar id y animal a la vista.'
      ],
      takeaway: 'El parámetro de la ruta debe llegar hasta la búsqueda.',
      accent: 'cyan'
    },
    {
      section: 'Detalle del animal',
      title: 'La vista representa los datos recibidos',
      lead: 'show.blade.php presenta el animal; no vuelve a consultar el servicio.',
      layout: 'code',
      codeTitle: 'resources/views/animals/show.blade.php',
      code: "<x-slot:title>Detalle de {{ $animal['name'] }}</x-slot:title>\n\n<span>ID: #{{ $animal['id'] }}</span>\n<span>Especie: {{ $animal['species'] }}</span>\n<h1>{{ $animal['name'] }}</h1>\n<p>Edad: {{ $animal['age'] }} años</p>\n\n<a href=\"{{ route('animals.edit', $id) }}\">Editar</a>",
      rightTitle: 'COMPROBAR',
      right: [
        'Los nombres de claves existen en el dato.',
        'La vista recibe $animal y $id.',
        'Blade escapa valores, por ejemplo {{ $animal[\'name\'] }}.',
        'Las acciones reutilizan rutas nombradas.'
      ],
      takeaway: 'Controlador prepara datos; Blade los representa.',
      accent: 'emerald'
    },
    {
      section: 'Detalle del animal',
      title: 'Prueba: un ID que sí existe',
      lead: 'Validamos el camino feliz usando un registro visible en el listado.',
      leftTitle: 'PASOS INDIVIDUALES',
      left: [
        'Abrir Animales desde el menú.',
        'Elegir un animal registrado.',
        'Pulsar su enlace Ver o su nombre.',
        'Comparar el detalle con la fila original.'
      ],
      rightTitle: 'SI NO COINCIDE',
      right: [
        'Revisar el ID incluido en la URL.',
        'Confirmar qué datos retorna find().',
        'Comprobar las claves que lee Blade.',
        'Seguir la respuesta en el controlador.'
      ],
      takeaway: 'Una prueba verificable compara entrada, consulta y salida.',
      accent: 'cyan'
    },
    {
      section: 'Detalle del animal',
      title: 'Prueba: un ID que no existe',
      lead: 'La implementación SQL activa construye una excepción, pero no la lanza.',
      layout: 'code',
      codeTitle: 'app/Services/SQLAnimalService.php',
      code: "$row = DB::selectOne(\n    'SELECT id, name, species, age FROM animals WHERE id = ?',\n    [$id]\n);\nif (!$row) {\n    AnimalNotFoundException::forId($id);\n}\nreturn (array) $row;",
      codeSize: 10,
      rightTitle: 'HALLAZGO DE CÓDIGO',
      right: [
        'AppServiceProvider enlaza SQLAnimalService.',
        'forId() crea una excepción, pero falta throw.',
        'No se ejecuta la ruta de excepción esperada.',
        'El controlador envía error como flash no renderizado.'
      ],
      takeaway: 'La prueba de ID inexistente revela un defecto en el servicio activo.',
      accent: 'emerald'
    },
    {
      section: 'Validación de creación',
      title: 'Antes de enviar: formulemos una predicción',
      lead: 'El primer intento completa sólo el nombre del animal.',
      layout: 'quiz',
      prompt: '¿Qué ocurrirá al enviar el formulario con name y dejar los demás campos vacíos?',
      options: [
        'A. Se crea el animal con valores vacíos.',
        'B. La validación rechaza la solicitud y devuelve errores.',
        'C. La vista show se abre automáticamente.'
      ],
      takeaway: 'Primero predecimos; después comprobamos con la regla real.',
      accent: 'cyan'
    },
    {
      section: 'Validación de creación',
      title: 'Primer envío: la validación detiene el alta',
      lead: 'El nombre está presente, pero species y age llegan vacíos.',
      layout: 'compare',
      leftTitle: 'ENTRADA DEL FORMULARIO',
      left: [
        'name: informado.',
        'species: vacío y obligatorio.',
        'age: vacío y obligatorio.'
      ],
      rightTitle: 'RESULTADO ESPERADO',
      right: [
        'La solicitud no supera AnimalDataRequest.',
        'store no completa la creación.',
        'Laravel vuelve al formulario con errores.',
        'La respuesta debe explicar qué corregir.'
      ],
      takeaway: 'Una solicitud rechazada no equivale a un animal creado.',
      accent: 'emerald'
    },
    {
      section: 'Validación de creación',
      title: 'El layout agrega un resumen del error bag',
      lead: 'El cambio reúne los mensajes de validación en una zona común de la página.',
      layout: 'code',
      codeTitle: 'resources/views/components/layout.blade.php',
      code: "@if ($errors->any())\n    <ul>\n        @foreach ($errors->all() as $error)\n            <li>{{ $error }}</li>\n        @endforeach\n    </ul>\n@endif",
      rightTitle: 'QUÉ RESUELVE',
      right: [
        'Comprueba si hay errores de validación.',
        'Recorre el error bag y lista los mensajes.',
        'Ayuda a diagnosticar campos incompletos.',
        'No captura excepciones globales.'
      ],
      takeaway: 'Este bloque hace visible la validación; no es un manejador universal.',
      accent: 'cyan'
    },
    {
      section: 'Validación de creación',
      title: 'FormRequest valida antes de store',
      lead: 'AnimalDataRequest concentra normalización, reglas y mensajes de validación.',
      layout: 'flow',
      steps: [
        'El formulario envía los campos.',
        'FormRequest prepara y valida.',
        'Si falla, Laravel redirige con errores.',
        'Si pasa, store recibe validated().'
      ],
      flowNote: 'Una solicitud inválida no llega al código que crea el animal.',
      takeaway: 'La validación protege la entrada antes de la lógica de almacenamiento.',
      accent: 'emerald'
    },
    {
      section: 'Validación de creación',
      title: 'Normalización antes de validar',
      lead: 'prepareForValidation transforma los textos recibidos antes de aplicar las reglas.',
      layout: 'code',
      codeTitle: 'AnimalDataRequest.php',
      code: "if ($this->has('name')) {\n    $this->merge([\n        'name' => Str::title(trim($this->input('name'))),\n    ]);\n}\n\nif ($this->has('species')) {\n    $this->merge([\n        'species' => Str::lower(trim($this->input('species'))),\n    ]);\n}",
      rightTitle: 'EFECTO',
      right: [
        'Se quitan espacios al inicio y final.',
        'El nombre se convierte a título.',
        'La especie se compara en minúsculas.',
        'La regla se aplica al valor preparado.'
      ],
      takeaway: 'Preparar no es validar: son pasos relacionados pero distintos.',
      accent: 'cyan'
    },
    {
      section: 'Validación de creación',
      title: 'Especie: obligatoria y dentro de la lista',
      lead: 'La regla in limita el valor a especies admitidas por la aplicación.',
      layout: 'wideCode',
      codeTitle: 'REGLA EN AnimalDataRequest.php',
      codeSize: 10,
      code: "'species' => 'required|string|in:león,elefante,pez payaso,gato,perro,conejo,caballo,oso,pájaro,tortuga',",
      right: [
        'Sólo el nombre no satisface required para species; el valor debe coincidir con una opción permitida.'
      ],
      takeaway: 'Un campo de texto libre no implica que cualquier valor sea válido.',
      accent: 'emerald'
    },
    {
      section: 'Validación de creación',
      title: 'Edad: entero obligatorio entre 3 y 30',
      lead: 'Las reglas actuales definen explícitamente el rango aceptado.',
      layout: 'code',
      codeTitle: 'AnimalDataRequest.php',
      code: "'name' => 'required|string|max:255',\n'age' => 'required|integer|min:3|max:30',",
      rightTitle: 'DATOS DE PRUEBA',
      right: [
        'name: Simba',
        'species: león',
        'age: 5',
        'La especie se normaliza a minúsculas.'
      ],
      takeaway: 'Las reglas del servidor son la fuente de verdad.',
      accent: 'cyan'
    },
    {
      section: 'Validación de creación',
      title: 'Cada campo puede mostrar su propio mensaje',
      lead: 'Blade asocia el mensaje al input y conserva la entrada previa con old().',
      layout: 'code',
      codeTitle: 'resources/views/animals/create.blade.php',
      code: "<input name=\"species\"\n    value=\"{{ old('species') }}\">\n\n@error('species')\n    <p>{{ $message }}</p>\n@enderror",
      rightTitle: 'LECTURA GUIADA',
      right: [
        '@error se enfoca en un campo.',
        '$message contiene el mensaje de ese error.',
        'old() recupera el valor reenviado.',
        'El resumen común vive en el layout.'
      ],
      takeaway: 'Feedback junto al campo y resumen común cumplen funciones complementarias.',
      accent: 'emerald'
    },
    {
      section: 'Validación de creación',
      title: 'Segundo intento: corregir y confirmar',
      lead: 'Completamos los campos y observamos la respuesta de éxito.',
      layout: 'flow',
      steps: [
        'Introducir Simba.',
        'Elegir león.',
        'Indicar edad 5.',
        'Enviar y verificar en el listado.'
      ],
      flowNote: 'store usa validated(), crea el animal y redirige con el flash success.',
      takeaway: 'Cerramos el ciclo: error explicado, datos corregidos y resultado verificado.',
      accent: 'cyan'
    },
    {
      section: 'Navegación y errores',
      title: 'El enlace Animales facilita probar el flujo',
      lead: 'El layout agrega navegación directa a animals.index y marca la sección activa.',
      layout: 'code',
      codeTitle: 'resources/views/components/layout.blade.php',
      code: "<a href=\"{{ route('animals.index') }}\"\n   class=\"{{ request()->routeIs('animals.*')\n       ? 'text-indigo-400 font-semibold'\n       : 'text-slate-400' }}\">\n    Animales\n</a>",
      rightTitle: 'APORTE A LA PRUEBA',
      right: [
        'Abre el listado sin escribir la URL.',
        'Permite repetir el alta desde un punto estable.',
        'El enlace no captura ni muestra excepciones.',
        'Es navegación, no manejo de errores.'
      ],
      takeaway: 'Una interfaz recorrible mejora la depuración y la experiencia.',
      accent: 'emerald'
    },
    {
      section: 'Navegación y errores',
      title: 'Tres mensajes que no debemos confundir',
      lead: 'La pantalla puede mostrar algunos errores y dejar otros mensajes invisibles.',
      layout: 'compare',
      leftTitle: 'ACTUALMENTE VISIBLE',
      left: [
        'Error bag de validación: $errors.',
        'Éxito de store: sesión success.',
        'Errores por campo: directiva @error.'
      ],
      rightTitle: 'BRECHA OBSERVADA',
      right: [
        'Los controladores envían sesión error.',
        'El layout no incluye @session("error").',
        'Por eso ese flash no se muestra.',
        'No se agregó un capturador global.'
      ],
      takeaway: 'Mostrar validación no equivale a gestionar todas las excepciones.',
      accent: 'cyan'
    },
    {
      section: 'Navegación y errores',
      title: 'Una nota profesional sobre excepciones',
      lead: 'Describimos el código actual y distinguimos esa descripción de una recomendación de producción.',
      layout: 'code',
      codeTitle: 'PATRÓN ACTUAL EN ALGUNAS ACCIONES',
      code: "catch (\\Exception $e) {\n    return redirect()->route('animals.index')\n        ->with('error', $e->getMessage());\n}",
      rightTitle: 'LECTURA CRÍTICA',
      right: [
        'Capturar Exception es amplio.',
        'El mensaje se envía como flash, no se renderiza hoy.',
        'No equivale a un handler global.',
        'En producción, registrar detalles y no exponerlos.'
      ],
      takeaway: 'La lección es observar el flujo sin presentar una brecha como solución.',
      accent: 'emerald'
    },
    {
      section: 'Síntesis y transferencia',
      title: 'Ticket de salida: reconstruye la evidencia',
      lead: 'Antes de cerrar, explica el proceso usando archivos y comportamientos observables.',
      leftTitle: 'RESPONDE INDIVIDUALMENTE',
      left: [
        '¿Por qué falló el primer envío?',
        '¿Qué archivo define las reglas?',
        '¿Cómo llega el ID hasta animals.show?',
        '¿Qué mensaje de error no se muestra?'
      ],
      rightTitle: 'CHECKLIST DE CALIDAD',
      right: [
        'Rutas y variables coherentes.',
        'Datos válidos comprobados.',
        'Resumen de validación bien nombrado.',
        'Handler global no atribuido al layout.'
      ],
      takeaway: 'Explicar evidencia concreta demuestra comprensión del backend.',
      accent: 'cyan'
    }
  ];
}
