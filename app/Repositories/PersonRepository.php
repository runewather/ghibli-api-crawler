<?php

namespace App\Repositories;

use App\Models\Character;

class PersonRepository
{
    public function getPeople() {
        return Character::with('film')->get();
    }
}
