<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacientes;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Contabilidadncstv;


class ShowDateController extends Controller
{
    public function showDate(){
        $usuarioAutenticado = Auth::user();
        $documentoUsuario = $usuarioAutenticado->documento;
        $idpaciente = Pacientes::where('grupofamiliar_id', $documentoUsuario)
        ->orWhere('idpaciente', $documentoUsuario)
        ->pluck('numeropaciente')
        ->toArray();

        $citas = Cita::whereIn('numeropaciente', $idpaciente)
        ->with('medico', 'paciente')
        ->orderBy('fechacita')
        ->get();

        $cancelada = $citas->contains('cancelada', 0) ? 'activo' : 'no activo';
        
        return view('showdate', [
            'idpaciente' => $idpaciente,
            'citas' => $citas,
            'cancelada' => $cancelada,
            
        ]);
    }
    public function canceldate(Request $request){
        $idCita = $request->input('id');
        /* dd($idCita); */
        $cita = Cita::where('idcita', $idCita)->first();
        $cita->cancelada = -1;
        $cita->save();
        
        return redirect('/show/date');
        /* return view('showdate'); */
    }
    
}