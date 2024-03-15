<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContabilidadEntidades extends Model
{
    use HasFactory;

    protected $connection = 'contabilidadncstv';

    protected $table = 'tabladenits';
}
