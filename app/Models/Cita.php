<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contabilidadncstv;
use App\Models\Pacientes;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $primaryKey = 'idcita';
    public $timestamps = false;
    protected $fillable = [
        'fechasolicitud',
        'fechacita',
        'idmedico',
        'fecita',
        'numeropaciente',
        'entidad',
        'fechapideusuario',
        'creadopor',
        'autorizacion',
        
    ];
    public function medico()
    {
        return $this->belongsTo(Contabilidadncstv::class, 'idmedico', 'cedula');
    }
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'numeropaciente', 'numeropaciente');
    }
}