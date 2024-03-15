<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PxCita extends Model
{
    use HasFactory;
    
    protected $table = 'pxcita';
    public $timestamps = false; 

    protected $fillable = [
        'idcita',
        'idservicio',
        'cups',
        'cantidad',
        'fechacreado',
    ];
}
