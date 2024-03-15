<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contabilidadncstv extends Model
{
    use HasFactory;

    protected $connection = 'contabilidadncstv';

    protected $table = 'usuarios';
}
