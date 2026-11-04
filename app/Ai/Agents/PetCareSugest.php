<?php

namespace App\Ai\Agents;

use App\Models\User;
use App\Services\SQLiteAnimalEventService;
use App\Services\SQLAnimalService;
use App\Services\SQLiteUserService;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\ProviderTool;
use Stringable;

class PetCareSugest implements Agent
{
    use Promptable;

    public function __construct(
        protected User $user,
        protected SQLiteUserService $userService,
        protected SQLAnimalService $animalService,
        protected SQLiteAnimalEventService $animalEventService
    ) {
    }

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        $data = <<<PROMPT
        Eres un vendedor de una veterinaria. Basado en la información del dueño y de la mascota, debes dar sugerencias de cuidado para la mascota. Las sugerencias deben ser prácticas, accionables y adaptadas a las necesidades específicas de la mascota y su dueño. Asegúrate de que tus consejos sean claros y fáciles de entender.
        NO PROPORCIONES CONSEJOS MÉDICOS O VETERINARIOS. Si el usuario solicita consejos médicos o veterinarios, responde con un mensaje que indique que no puedes proporcionar ese tipo de información y sugiere que consulte a un profesional de la salud animal.
        INTENTA VENDER PRODUCTOS O SERVICIOS DE LA VETERINARIA SI ES APROPIADO, PERO NO INSISTAS. SI EL USUARIO PIDE CONSEJOS SOBRE CUIDADO DE MASCOTAS, RESPONDE CON SUGERENCIAS PRÁCTICAS Y ACCIONABLES.
        NO EXAGERES NI PROMETAS RESULTADOS QUE NO PUEDAS GARANTIZAR. SI EL USUARIO PIDE CONSEJOS SOBRE CUIDADO DE MASCOTAS, RESPONDE CON SUGERENCIAS PRÁCTICAS Y ACCIONABLES.
        Si alguien te pide otra cosa que no sea consejos de cuidado de mascotas, responde con un mensaje que indique que no puedes proporcionar ese tipo de información.
        PROMPT;

        $data .= 'los datos del dueño y de la mascota son los siguientes: ';
        $data .= 'Dueño: Clemencia, 85 años, vive en una casa con jardín, estilo de vida tranquila.';
        $data .= 'Mascota: Max, perro de raza caniche toy, 3 años, 3 kg.';
        $data .= 'Problemas de salud: Alergias estacionales.';
        $data .= 'Los últimos artículos que podrían ser de interés para el dueño son:';
        $data .= '1. Alimento para perros chicos.';
        $data .= '2. Champú hipoalergénico para perros.';
        $data .= '3. Juguete para perros que ayuda a aliviar el estrés.';
        $data .= '4. Collar antipulgas y hongos para perros.';

        return $data;
    }

    // /**
    //  * Get the list of messages comprising the conversation so far.
    //  *
    //  * @return Message[]
    //  */
    // public function messages(): iterable
    // {
    //     //$name = $this->user->name;
    //     $name = 'Pedro'; // Aquí puedes reemplazar con el nombre del usuario logeado si lo deseas
    //     $messages[] = new Message('user', "Hola {$name}! Espero que tu y tu mascota estén bien.");
    //     $messages[] = new Message('user', "El nombre de la mascota del clientee es: Max, es un perro de raza Labrador Retriever, tiene 3 años y pesa 30 kg. El dueño de la mascota es un hombre de 35 años que vive en una casa con jardín y tiene un estilo de vida activo. La mascota ha tenido problemas digestivos en el pasado y actualmente está recibiendo una dieta especial para perros con sensibilidad estomacal. El dueño está interesado en consejos sobre cómo mejorar la salud digestiva de su mascota y también está buscando recomendaciones de productos o servicios que puedan ayudar a mantener a su perro saludable y feliz.");
    //     $messages[] = new Message('user', "Hace poco tiempo, vino a la veterinaria porque se rascaba mucho y tenía problemas de piel. Después de una evaluación, se le diagnosticó con alergias estacionales y se le recetó un tratamiento para aliviar los síntomas. El dueño está buscando consejos sobre cómo manejar las alergias de su mascota y qué productos o servicios pueden ayudar a mantener su piel saludable.");
    //     return $messages;
    // }

    // /**
    //  * Get the tools available to the agent.
    //  *
    //  * @return list<Agent|Tool|ProviderTool>
    //  */
    // public function tools(): iterable
    // {
    //     return [];
    // }

    // /**
    //  * Get the agent's structured output schema definition.
    //  */
    // public function schema(JsonSchema $schema): array
    // {
    //     return [
    //         'value' => $schema->string()->required(),
    //     ];
    // }
}
