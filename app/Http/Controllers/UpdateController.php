<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pacientes;
use App\Models\Entidad;
use App\Models\ContabilidadEntidades;
use App\Models\User;


class UpdateController extends Controller
{
    public function update()
{
    $usuarioAutenticado = Auth::user();
    $documentoUsuario = $usuarioAutenticado->documento;
    
    $entidades = Entidad::where('Cexterna', -1)->pluck('nit');
    $nombresEntidades = ContabilidadEntidades::whereIn('idtercero', $entidades)->pluck('nombre','idtercero');
    
    $paciente = Pacientes::where('idpaciente', $documentoUsuario)
        ->leftJoin('entidades', 'pacientes.entidadpaciente', '=', 'entidades.identidad')
        ->first(['pacientes.*', 'entidades.nombreentidad', 'entidades.nit']);

    $grupofamiliar = Pacientes::where('grupofamiliar_id', $documentoUsuario)
    
    ->get();
    

    if ($paciente) {
        // Paciente encontrado, retornar todos los datos del paciente
        return view('update', [
            'paciente' => $paciente,
            'nombresEntidades' => $nombresEntidades,
            'grupofamiliar' => $grupofamiliar
        ]);
    } else {
        // Paciente no encontrado, retornar mensaje indicando que no existe
        return view('update', [
            'nombresEntidades' => $nombresEntidades
        ]);
    }
}


    public function create(Request $request)
{
    try {
        // Obtener los valores de los campos del formulario
        $usuarioAutenticado = Auth::user();
        $documentoUsuario = $usuarioAutenticado->documento;
        $tiposdoc = $request->input('tiposdoc');
        $nombre1 = $request->input('nombre1');
        $sexopaciente = $request->input('sexopaciente');
        $entidadpaciente = $request->input('entidad');
        $apellido1 = $request->input('apellido1');
        $nombre2 = $request->input('nombre2');
        $direccion = $request->input('direccion');
        $apellido2 = $request->input('apellido2');
        $telefono = $request->input('telefono');
        $correoe = $request->input('correoe');
        $fechanacimiento = $request->input('fechanacimiento');
        $ncompleto = $apellido1 . ' ' . $apellido2 . ' ' . $nombre1 . ' ' . $nombre2;

        

        // Crear una nueva instancia del modelo Pacientes con los valores obtenidos
        $paciente = new Pacientes([
            'tipoid' => $tiposdoc,
            'idpaciente' => $documentoUsuario,
            'nombre1' => $nombre1,
            'sexopaciente' => $sexopaciente,
            'entidadpaciente' => $entidadpaciente,
            'apellido1' => $apellido1,
            'nombre2' => $nombre2,
            'direccion' => $direccion,
            'apellido2' => $apellido2,
            'telefono' => $telefono,
            'correoe' => $correoe,
            'fechanacimiento' => $fechanacimiento,
            'ncompleto' => $ncompleto,
            'entidadpaciente' => $entidadpaciente,
        ]);

        // Guardar el nuevo paciente en la base de datos
        $paciente->save();

        // Retornar una respuesta indicando que los datos se han guardado correctamente
        return response()->json([
            'mensaje' => 'Datos guardados correctamente',
            'paciente' => $paciente, // Puedes devolver el objeto del paciente guardado si lo necesitas
        ]);
    } catch (\Exception $e) {
        // Capturar y manejar la excepción
        return response()->json([
            'error' => 'Error al guardar los datos: ' . $e->getMessage(),
        ], 500); // Puedes ajustar el código de estado HTTP según sea necesario
    }
}

public function entidad(Request $request){
    $selectedValue = $request->input('selectedValue');
    $selectedId = $request->input('selectedId');
    $regimen = Entidad::where('nit', $selectedId)
        ->where('Cexterna', -1)
        ->get(['tipoentidad', 'identidad']); // Modificado

    // Mapear los resultados y ajustar el tipo de entidad
    $regimen = $regimen->map(function ($item) {
        $item->tipoentidad = ($item->tipoentidad == '01') ? 'CONTRIBUTIVO' : 'SUBSIDIADO';
        return $item;
    });

    return response()->json([
        'selectedId' => $selectedId,
        'selectedValue' => $selectedValue,
        'regimen' => $regimen->toArray()
    ]);
}


public function codigoentidad(Request $request){
    // Obtener el selectedId del cuerpo de la solicitud
    $selectedId = $request->input('selectedId');

    // Puedes realizar cualquier lógica adicional aquí si es necesario

    // Devolver el mismo dato en formato JSON
    return response()->json(['selectedId' => $selectedId]);
}

public function updateexisting(Request $request){
    $usuarioAutenticado = Auth::user();
    $documentoUsuario = $usuarioAutenticado->documento;
    $nombreusuario = $usuarioAutenticado->name;

    $tipoDocumento = $request->input('tipodoc');
    $primerNombre = $request->input('nombre1');
    $sexoPaciente = $request->input('sexopaciente');
    $fechaNacimiento = $request->input('fechanacimiento');
    $primerApellido = $request->input('apellido1');
    $segundoNombre = $request->input('nombre2');
    $direccion = $request->input('direccion');
    $segundoApellido = $request->input('apellido2');
    $telefono = $request->input('telefono');
    $correoElectronico = $request->input('email');

    $paciente = Pacientes::where('idpaciente', $documentoUsuario)->first(); 

        $paciente->tipoid = $tipoDocumento;
        $paciente->nombre1 = $primerNombre;
        $paciente->sexopaciente = $sexoPaciente;
        $paciente->fechanacimiento = $fechaNacimiento;
        $paciente->apellido1 = $primerApellido;
        $paciente->nombre2 = $segundoNombre;
        $paciente->direccion = $direccion;
        $paciente->apellido2 = $segundoApellido;
        $paciente->telefono = $telefono;
        $paciente->correoe = $correoElectronico;

        // Guardar los cambios en la base de datos
        $paciente->save();
        return view('update', [
            'paciente' => $paciente,
            'nombreusuario' => $nombreusuario
        ]);


}

public function miembros(Request $request){
    try {
        $usuarioAutenticado = Auth::user();
        $documentoUsuario = $usuarioAutenticado->documento;

        $tipoDocumento = $request->input('tiposdoc2');
        $documento = $request->input('documento_1_1');
        $primerApellido = $request->input('apellido1_1');
        $segundoApellido = $request->input('apellido2_1');
        $primerNombre = $request->input('nombre1_1');
        $segundoNombre = $request->input('nombre2_1');
        $telefono = $request->input('telefono_1');
        $direccion = $request->input('direccion_1');
        $codigoRegimen = $request->input('Regimen_1');
        $fechaNacimiento = $request->input('fechanacimiento_1');
        $sexo = $request->input('sexopaciente_1');
        $email = $request->input('email_1');
        $entidad = $request->input('entidad_1');
        $ncompleto = $primerApellido . ' ' . $segundoApellido . ' ' . $primerNombre . ' ' . $segundoNombre;

        $paciente = Pacientes::where('idpaciente', $documento)->first();

        if (!$paciente) {
            // Si el paciente no existe, se crea uno nuevo
            $paciente = new Pacientes();
            $paciente->idpaciente = $documento;
            $paciente->tipoid = $sexo;
            $paciente->nombre1 = $primerNombre;
            $paciente->nombre2 = $segundoNombre;
            $paciente->apellido1 = $primerApellido;
            $paciente->apellido2 = $segundoApellido;
            $paciente->fechanacimiento = $fechaNacimiento;
            $paciente->sexopaciente = $sexo;
            $paciente->telefono = $telefono;
            $paciente->direccion = $direccion;
            $paciente->correoe = $email;
            $paciente->ncompleto = $ncompleto;
            $paciente->entidadpaciente = $entidad;
            $paciente->grupofamiliar_id = $documentoUsuario;
            $paciente->save();
            $request->session()->flash('success', 'Datos guardados exitosamente.');
        } elseif ($documento != 0 && $paciente->grupofamiliar_id == 0) {
            // Si el documento existe y el grupofamiliar_id es 0, se actualiza todo excepto el documento
            $paciente->apellido1 = $primerApellido;
            $paciente->apellido2 = $segundoApellido;
            $paciente->nombre1 = $primerNombre;
            $paciente->nombre2 = $segundoNombre;
            $paciente->fechanacimiento = $fechaNacimiento;
            $paciente->sexopaciente = $sexo;
            $paciente->telefono = $telefono;
            $paciente->direccion = $direccion;
            $paciente->correoe = $email;
            $paciente->ncompleto = $ncompleto;
            $paciente->entidadpaciente = $entidad;
            $paciente->grupofamiliar_id = $documentoUsuario;
            $paciente->save();

            $request->session()->flash('success', 'Datos actualizados exitosamente.');
        } else {
            // Si el paciente existe y el documento es 0 o el grupofamiliar_id no es 0, se actualiza todo normalmente
            $paciente->tipoid = $tipoDocumento;
            
            $paciente->apellido1 = $primerApellido;
            $paciente->apellido2 = $segundoApellido;
            $paciente->nombre1 = $primerNombre;
            $paciente->nombre2 = $segundoNombre;
            $paciente->fechanacimiento = $fechaNacimiento;
            $paciente->sexopaciente = $sexo;
            $paciente->telefono = $telefono;
            $paciente->direccion = $direccion;
            $paciente->correoe = $email;
            $paciente->ncompleto = $ncompleto;
            $paciente->entidadpaciente = $entidad;
            $paciente->grupofamiliar_id = $documentoUsuario;

            $paciente->save();

            $request->session()->flash('success', 'Datos guardados exitosamente.');
        }
    } catch (\Exception $e) {
        $request->session()->flash('error', 'Ha ocurrido un error al guardar los datos.');
        \Log::error('Error al guardar los datos: ' . $e->getMessage());
    }

    return redirect('/update');
}


public function validarMiembro(Request $request)
    {
        $documento = $request->input('documento');

        $documentoUsuario = User::where('documento', $documento)->first();

        // Supongamos que tienes un modelo llamado "Miembro" y quieres buscar un miembro por su documento
        $miembro = Pacientes::where('idpaciente', $documento)->first();
        

        // Verificar si se encontró un miembro
         if ($miembro) {
        // Si se encuentra el miembro, puedes devolver los datos que necesites, incluyendo el documento del usuario autenticado
        return response()->json(['miembro' => $miembro, 'documentoUsuario' => $documentoUsuario]);
        } else {
        // Si no se encuentra el miembro, puedes devolver un mensaje de error o cualquier otra cosa que necesites
        return response()->json(['error' => 'No se encontró ningún miembro con el documento proporcionado.']);
        }
    }



}