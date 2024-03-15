<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contabilidadncstv;
use App\Models\Entidad;
use App\Models\Especialistas;
use App\Models\ConfiguracionCitas;

class ContabilidadController extends Controller
{
    public function index(Request $request)
    {
        $entidades = Entidad::where('Cexterna', -1)->get();
        $especialidades = Especialistas::all();
        $nombreEspecialidad = $request->input('nombreespecialidad');

        // Usa explode para separar el nombre y el id
        $especialidadArray = explode(' ', $nombreEspecialidad);
    
        // Accede al id de la especialidad
        $idEspecialidad = end($especialidadArray);
    
       

        
        return view('home', compact('usuarios','entidades', 'especialidades'));
    }
}