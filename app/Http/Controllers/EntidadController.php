<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;
use App\Models\Especialistas;
use App\Models\Contabilidadncstv;
use App\Models\ConfiguracionCitas;
use App\Models\ConfiguracionExepcionDias;
use App\Models\cita;
use carbon\Carbon;
use App\Models\Cupsxservicio;
use App\Models\CodigoCupsNombre;
use Illuminate\Support\Facades\Auth;
use App\Models\Pacientes;



class EntidadController extends Controller
{
    public function index(Request $request)
    {
        $entidades = Entidad::where('Cexterna', -1)->get();
        $especialidades = Especialistas::all();
        
        return view('home', compact('entidades', 'especialidades'));
    }
    public function show(Request $request)
{
    $entidades = Entidad::where('Cexterna', -1)->get();
    $especialidades = Especialistas::all();
    $nombreEspecialidad = $request->input('nombreespecialidad');
    $idEspecialidad = $request->input('idespecialidad');
    
    // Usa explode para separar el nombre y el id
    $especialidadArray = explode(' ', $nombreEspecialidad);

    // Accede al nombre de la especialidad
    

    $resultados = Contabilidadncstv::where('especialidad', $idEspecialidad)
    ->pluck('cedula', 'nombrereal','cortesia')
    ->toArray();

    $citasconf = ConfiguracionCitas::where('activo', -1)
        ->pluck('idmedico')
        ->toArray();

    // Filtrar los resultados basados en la igualdad de cedula e idmedico
    $resultadoFinal = array_filter($resultados, function ($idMedico, $cortesia) use ($citasconf) {
        return in_array($idMedico, $citasconf);
    }, ARRAY_FILTER_USE_BOTH);
    

    $cedulas = array_values($resultadoFinal);
    $cups = Cupsxservicio::select('cups', 'servicio')->get();

    $nombrecups = Cupsxservicio::join('codigossoat', 'cupsxservicio.cups', '=', 'codigossoat.codigocups')
    ->select('cupsxservicio.cups', 'cupsxservicio.servicio', 'codigossoat.descripcioncups')
    ->get();


    return view('home', compact('entidades', 'especialidades', 'nombreEspecialidad','resultadoFinal','cedulas','cups','nombrecups'));
}

public function consult($cedula)
{
    
    $resultado = ConfiguracionExepcionDias::where('idtercero', $cedula)
        ->where('tipoexcepcion', 1)
        ->where(function ($query) {
            $query->whereYear('fecha', Carbon::now()->year)
                ->orWhereYear('fecha', Carbon::now()->year + 1);
        })
        ->orderBy('fecha', 'desc')
        ->get(['fecha']);

    return response()->json($resultado);
}

public function horario(Request $request)
{
    
    $usuarioAutenticado = Auth::user();
    $documentoUsuario = $usuarioAutenticado->documento;

    $cedulaEspecialista = $request->input('cedulaEspecialista');
    $fechaCarbon = Carbon::parse($request->input('fecha'));
    $fechacomparar = $fechaCarbon->format('Y-m-d');
    $fechaparalashoras = $fechaCarbon->format('Ymd');
    $nombreDia = $fechaCarbon->format('w');

    $horainiciom = 'hiniciom' . $nombreDia;
    $horafinalm = 'hfinalm' . $nombreDia;
    $horainiciot = 'hiniciot' . $nombreDia;
    $horafinalt = 'hfinalt' . $nombreDia;
    $trabaja = 'trabaja' . $nombreDia;


    //Consulto el numero de citas posibles
    $consulta = ConfiguracionExepcionDias::where('idtercero', $cedulaEspecialista)
    ->where('fecha', $fechacomparar)
    ->first(['kcitas', 'jornadam']);

    $grupofamiliar = Pacientes::where('grupofamiliar_id', $documentoUsuario)
    ->select('nombre1', 'nombre2', 'apellido1', 'apellido2', 'idpaciente')
    ->get();
    
    $cotizante = Pacientes::where('idpaciente', $documentoUsuario)
    ->select('nombre1', 'nombre2', 'apellido1', 'apellido2', 'idpaciente')
    ->first();

    if ($consulta) {
        $kcitas = $consulta->kcitas;
        $jornadam = $consulta->jornadam;
    }
    
    $consultat = ConfiguracionExepcionDias::where('idtercero', $cedulaEspecialista)
        ->where('fecha', $fechacomparar )
        ->first(['kcitast','jornadat']);
        
        if ($consultat) {
            $kcitast = $consultat->kcitast;
            $jornadat = $consultat->jornadat;
        }

    //consulto las horas que tiene configurada ese medico en formato YmdHi y a partir de kcitas de la mañana
    if ($kcitas == 0 && $jornadam == -1) {
    $armarrangomañana = ConfiguracionCitas::where('idmedico', $cedulaEspecialista)
        ->where('activo', -1)
        ->where($trabaja, -1)
        ->select($horainiciom, $horafinalm, 'duracioncita')
        ->first(); 

        if ($armarrangomañana) {
            $horaInicio = \Carbon\Carbon::parse($armarrangomañana->$horainiciom);
            $horaFinal = \Carbon\Carbon::parse($armarrangomañana->$horafinalm);
            $duracionCita = $armarrangomañana->duracioncita;

            $horasArray = [];
        
            for (; $horaInicio->lt($horaFinal); $horaInicio->addMinutes($duracionCita)) {
                $horasArray[] = $horaInicio->format('YmdHi');
            }
        
            // Reemplazar 'Ymd' en cada elemento de $horasArray
            $horasArray = array_map(function ($hora) use ($fechaparalashoras) {
                return substr_replace($hora, $fechaparalashoras, 0, 8);
            }, $horasArray);
        }
    }elseif ($kcitas > 0) {
        //consulto las horas que tiene configurada ese medico en formato YmdHi y a partir de kcitas de la tarde
        $armarrangomañana = ConfiguracionCitas::where('idmedico', $cedulaEspecialista)
            ->where('activo', -1)
            ->where($trabaja, -1)
            ->select($horainiciom, $horafinalm, 'duracioncita')
            ->first();
    
            if ($armarrangomañana) {
                $horaInicio = \Carbon\Carbon::parse($armarrangomañana->$horainiciom);
                
                for ($i = 0, $horasArray = []; $i < $kcitas; $i++, $horaInicio->addMinutes($armarrangomañana->duracioncita)) {
                    $horasArray[] = substr_replace($horaInicio->copy()->format('YmdHi'), $fechaparalashoras, 0, 8);
                }
            }
            
    }
    //consulto la fecha que ya hay asignadas citas
    $tablahoras = Cita::where('idmedico', $cedulaEspecialista)
    ->where('fecita', 'like', '%' . $fechacomparar . '%')
    ->where('cancelada', 0)
    ->pluck('fechacita')
    ->toArray();

    

    $horasfinalmañana = (isset($horasArray) && isset($tablahoras))
        ? array_values(array_diff($horasArray, $tablahoras))
        : [];

    //consulto las horas que tiene configurada ese medico en formato YmdHi y a partir de kcitas de la función
        if ($kcitast == 0 && $jornadat == -1) {
            $armarrangotarde = ConfiguracionCitas::where('idmedico', $cedulaEspecialista)
                ->where('activo', -1)
                ->where($trabaja, -1)
                ->select($horainiciot, $horafinalt, 'duracioncita')
                ->first();
        
            if ($armarrangotarde) {
                $horaInicioTarde = \Carbon\Carbon::parse($armarrangotarde->$horainiciot);
                $horaFinalTarde = \Carbon\Carbon::parse($armarrangotarde->$horafinalt);
                $duracionCitaTarde = $armarrangotarde->duracioncita;
        
                $horasArrayTarde = [];
        
                for (; $horaInicioTarde->lt($horaFinalTarde); $horaInicioTarde->addMinutes($duracionCitaTarde)) {
                    $horasArrayTarde[] = $horaInicioTarde->format('YmdHi');
                }
        
                // Reemplazar 'Ymd' en cada elemento de $horasArrayTarde
                $horasArrayTarde = array_map(function ($hora) use ($fechaparalashoras) {
                    return substr_replace($hora, $fechaparalashoras, 0, 8);
                }, $horasArrayTarde);
            }
        } elseif ($kcitast > 0) {
            // Consulto las horas que tiene configuradas ese medico en formato YmdHi
            $armarrangotarde = ConfiguracionCitas::where('idmedico', $cedulaEspecialista)
                ->where('activo', -1)
                ->where($trabaja, -1)
                ->select($horainiciot, $horafinalt, 'duracioncita')
                ->first();
        
            if ($armarrangotarde) {
                $horaInicioTarde = \Carbon\Carbon::parse($armarrangotarde->$horainiciot);
        
                for ($i = 0, $horasArrayTarde = []; $i < $kcitast; $i++, $horaInicioTarde->addMinutes($armarrangotarde->duracioncita)) {
                    $horasArrayTarde[] = substr_replace($horaInicioTarde->copy()->format('YmdHi'), $fechaparalashoras, 0, 8);
                }
            }
        }
        
        // Consulto las fechas que ya tienen citas asignadas
        $tablaHorasTarde = Cita::where('idmedico', $cedulaEspecialista)
            ->where('fecita', 'like', '%' . $fechacomparar . '%')
            ->where('cancelada', 0)
            ->pluck('fechacita')
            ->toArray();
        
        $horasFinalTarde = (isset($horasArrayTarde) && isset($tablaHorasTarde))
            ? array_values(array_diff($horasArrayTarde, $tablaHorasTarde))
            : [];

        return response()->json([
            'cedulaEspecialista' => $cedulaEspecialista,
            'horasfinalmañana' => $horasfinalmañana,
            'horasFinalTarde' => $horasFinalTarde,
            'kcitas' => $kcitas,
            'jornadam' => $jornadam,
            'kcitast' => $kcitast,
            'jornadat' => $jornadat,
            'cotizante' => $cotizante,
            'grupofamiliar' => $grupofamiliar,
            
        ]);
}


}