<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    use HasFactory;
    const CREATED_AT = 'fechacreado';
    const UPDATED_AT = 'fechamodificado';

    public $timestamps = false; 
    
    protected $table = 'pacientes';
    protected $primaryKey = 'idpaciente';
    protected $fillable = [
        'tipoid',
        'idpaciente',
        'apellido1',
        'apellido2',
        'nombre1',
        'nombre2',
        'telefono',
        'correoe',
        'entidadpaciente',
        'sexopaciente',
        'fechanacimiento',
        'direccion',
        'ncompleto',
        'grupofamiliar_id',
    ];
    public static $rules = [
        'tipoid' => 'unique:pacientes,TipoID',
    ];
    public function grupoFamiliar()
    {
        return $this->belongsTo(Pacientes::class, 'grupofamiliar_id', 'idpaciente');
    }
}