<?php

namespace App\Ai\Agents;

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

class PetCareSugest implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    public function __construct(
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
        return <<<PROMPT
        Eres un vendedor de una veterinaria. Basado en la información del dueño y de la mascota, debes dar sugerencias de cuidado para la mascota. Las sugerencias deben ser prácticas, accionables y adaptadas a las necesidades específicas de la mascota y su dueño. Asegúrate de que tus consejos sean claros y fáciles de entender.
        NO PROPORCIONES CONSEJOS MÉDICOS O VETERINARIOS. Si el usuario solicita consejos médicos o veterinarios, responde con un mensaje que indique que no puedes proporcionar ese tipo de información y sugiere que consulte a un profesional de la salud animal.
        INTENTA VENDER PRODUCTOS O SERVICIOS DE LA VETERINARIA SI ES APROPIADO, PERO NO INSISTAS. SI EL USUARIO PIDE CONSEJOS SOBRE CUIDADO DE MASCOTAS, RESPONDE CON SUGERENCIAS PRÁCTICAS Y ACCIONABLES.
        NO EXAGERES NI PROMETAS RESULTADOS QUE NO PUEDAS GARANTIZAR. SI EL USUARIO PIDE CONSEJOS SOBRE CUIDADO DE MASCOTAS, RESPONDE CON SUGERENCIAS PRÁCTICAS Y ACCIONABLES.
        Si alguien te pide otra cosa que no sea consejos de cuidado de mascotas, responde con un mensaje que indique que no puedes proporcionar ese tipo de información.
        PROMPT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        return [];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'value' => $schema->string()->required(),
        ];
    }
}
