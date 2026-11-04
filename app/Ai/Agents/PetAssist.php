<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use App\Models\User;
use Laravel\Ai\Promptable;
use App\Contracts\AnimalServiceInterface;
use App\Contracts\SpeciesServiceInterface;
use App\Contracts\AnimalOwnerServiceInterface;
use App\Contracts\AnimalEventServiceInterface;
use Stringable;

class PetAssist implements Agent
{
    use Promptable;

    public function __construct(
        protected User $user,
        protected AnimalServiceInterface $animalService,
        protected SpeciesServiceInterface $speciesService,
        protected AnimalOwnerServiceInterface $animalOwnerService,
        protected AnimalEventServiceInterface $animalEventService
    ) {
    }

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        $prompt = <<<PROMPT
        Serás un vendedor de la tienda de mascotas "Pet's Care" y tu objetivo es FIDELIZAR a los clientes, saludarlos amistosamente, preguntarles por sus mascotas, y ofrecerles productos y servicios de la tienda.
        NO DEBES DAR CONSEJOS VETERINARIOS NI DE SALUD, SOLO DE PRODUCTOS Y SERVICIOS DE LA TIENDA.
        NO INICIES UNA CONVERSACIÓN, SÓLO DA EL MENSAJE DE SALUDO, OFERTA Y FIDELIZACIÓN, NO OLVIDES
        REFERIRTE AL CLIENTE POR SU NOMBRE Y A SUS MASCOTAS POR SU NOMBRE TAMBIÉN.
        SE AMIGABLE, CERCANO Y CORDIAL, Y CONCISO, NO TE EXTIENDAS DEMASIADO, SOLO UN MENSAJE CORTO Y AMIGABLE.
        PROMPT;

        $prompt .= "El nombre del cliente es: {$this->user->name}.\n";
        $prompt .= "El email del cliente es: {$this->user->email}.\n";

        $prompt .= "El cliente tiene las siguientes mascotas:\n";
        $prompt .= "- Perro labrador de 3 años llamado Max.\n";
        $prompt .= "- Gato siamés de 2 años llamado Luna.\n";
        $prompt .= "El perro Max, tuvo una intervención quirúrgica hace 6 meses y está en proceso de recuperación.\n";

        return $prompt;
    }
}
