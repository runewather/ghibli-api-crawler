<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    protected $primaryKey = 'character_id';

    public $timestamps = false;
}
