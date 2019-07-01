<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'films';

    protected $primaryKey = 'film_id';

    public $timestamps = false;
}
