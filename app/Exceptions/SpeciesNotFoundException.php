<?php

namespace App\Exceptions;

use Exception;

class SpeciesNotFoundException extends Exception
{
    public static function forId(string $id)
    {
        return new self("La especie con ID \"$id\" no fue encontrada.");
    }
}