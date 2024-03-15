<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Pacientes;
use App\Models\PxCita;


class CitaguardadaController extends Controller
{
    public function guardar(Request $request)
{
    // Obtener los datos del formulario
    $fechaFormateada = $request->input('fechaFormateada');
    $usuarioAutenticado = Auth::user();
    $documentoUsuario = $request->input('idpaciente');
    $entidad = Pacientes::where('idpaciente', $documentoUsuario)->value('entidadpaciente');
    $autorizacion = $request->input('autorizacion');
    $cups = $request->input('cups');
    $servicio = $request->input('servicio');
    $cantidad = $request->input('cantidad');
    
    // Obtener el número de paciente solo si no es nulo
    $numeropaciente = null;
    if (!is_null($documentoUsuario)) {
        $numeropaciente = Pacientes::where('idpaciente', $documentoUsuario)->value('numeropaciente');
    }

    // Verificar si se obtuvo el número de paciente
    if (!is_null($numeropaciente)) {

        $fechaHoraSeleccionada = $request->input('fechaHoraSeleccionada');
        $documento = $request->input('documento');
        $fecita = $request->input('fecita');
        $direccion = $request->input('direccion');

        $existingCita = Cita::where('fecita', $fecita)
                            ->where('numeropaciente', $numeropaciente)
                            ->where('cancelada', 0)
                            ->first();

        if ($existingCita) {
            return response()->json(['message' => 'Ya tiene una cita asignada para este dia']);
        }                   
        // Crear una nueva instancia del modelo Cita
        $cita = new Cita([
            'fechasolicitud' => $fechaFormateada,
            'fechacita' => $fechaHoraSeleccionada,
            'idmedico' => $documento,
            'fecita' => $fecita,
            'numeropaciente' => $numeropaciente,
            'direccion' => $direccion,
            'fechapideusuario' => $fecita,
            'entidad' => $entidad,
            'creadopor' => '999999',
            'autorizacion' => $autorizacion
        ]);

        // Guardar la cita en la base de datos de citas
        $cita->save();
        
        //guardar la cita en pxcita
        $idCitaCreada = $cita->idcita;
        $fechaCitaGuardada = $cita->fechacita;
        $pxcita = new PxCita([
            'idcita' => $idCitaCreada,
            'cups' => $cups,
            'idservicio' => $servicio,
            'cantidad' => $cantidad,
            'fechacreado' => $fechaFormateada,
        ]);
        $pxcita->save();

        // Puedes devolver una respuesta o redirigir a otra página después de guardar
        return response()->json(['pxcita' => $fechaCitaGuardada, 'message' => 'Cita guardada con éxito']);
        
        
    } 
    
    
    else {
        // Manejar el caso donde numeropaciente es nulo
        return response()->json([
            'message' => 'Asegurese de escoger un miembro y el horario para la cita',
        ]);
        
    }
}

}