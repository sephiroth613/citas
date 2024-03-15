<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Entidad;
use Illuminate\Http\Request;
use App\Models\ContabilidadEntidades;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'documento' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($data) {
                    return $query->where('documento', $data['documento']);
                }),
            'entidad' => ['required', 'string', 'max:255'],
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'documento' => $data['documento'],
            'entidad' => $data['idtercero'],
            
        ]);
    }

    public function showRegistrationForm()
    {
        $entidades = Entidad::where('Cexterna', -1)->pluck('nit');
        $nombresEntidades = ContabilidadEntidades::whereIn('idtercero', $entidades)
        ->orderBy('nombre')
        ->pluck('nombre', 'idtercero');

        return view('auth.register', compact('nombresEntidades'));
    }

    public function entidad(Request $request){
        $selectedValue = $request->input('selectedValue');
        $selectedId = $request->input('selectedId');
        

        $regimen = Entidad::where('nit', $selectedId)
            ->where('Cexterna', -1)
            ->get(['tipoentidad', 'identidad']); 
    
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



    
}