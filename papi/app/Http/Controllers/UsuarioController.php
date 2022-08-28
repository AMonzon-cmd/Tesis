<?php

namespace App\Http\Controllers;

use App\Http\Requests\AltaClienteFisicoRequest;
use App\Http\Requests\AltaUsuarioRequest;
use App\Models\PersonaFisica;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    
    protected function altaPersonaFisica(AltaClienteFisicoRequest $request){
        try{
            DB::beginTransaction();
            $datosNuevoUsuario = $request->all();
            $nuevoUsuario = $this->_crearUsuario($datosNuevoUsuario);
            $this->_crearPersonaFisica($nuevoUsuario->id, $datosNuevoUsuario);
            DB::commit(); 
            return response()->json(['respuesta' => 'Alta generada correctamente.'],200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['respuesta' => 'Error al generar el alta, contacte a soporte.'], 500);
        }
    }

    // private function validar($datos)
    // {
    //     $user = User::where('email', $datos['email'])->first();

    //     if($user){
    //         throw new Exception('El email esta siendo utilizado');
    //     }
    // }

    protected function altaPersonaJuridica(AltaUsuarioRequest $request){
        try{
            $datosNuevoUsuario = $request->all();   
            $nuevoUsuario = $this->_crearUsuario($datosNuevoUsuario);
            
            if(!$nuevoUsuario){
                return response()->json(['respuesta' => 'Error generar el usuario.'], 400);
            }

            $datosUsuario = ($datosNuevoUsuario['tipo'] == 1) ? $this->crearPersonaFisica($nuevoUsuario) : $this->crearPersonaJuridica($nuevoUsuario);
            
            if(!$datosUsuario){
                return response()->json(['respuesta' => 'Error al cargar los datos el cliente.'], 400);
            }

            return response()->json(['respuesta' => 'Alta generada correctamente.'. 200]);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'Error al generar el alta, contacte a soporte.'], 500);
        }
    }

    protected function baja(Request $request){

    }


    protected function modificaion(){

    }


    protected function obtenerUsuarios($id = null){
        try{
            if(!$id){
                $usuarios = User::with('datos')->get();
                return response()->json(["respuesta" => 'Listado de usuarios obtenido correctamente.', 'usuarios' => $usuarios], 200);
            }
            $usuario = User::findOrFail($id);
            $usuario->datos;
            return response()->json(['respuesta' => 'Usuario obtenido correctamente.', 'usuario' => $usuario], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'El usuario/s no existen en el sistema.'], 500);
        }
    }




    /////////////////////////////////////////////////////////////////////
    ////////////////////// METODOS PRIVADOS ////////////////////////////
    ////////////////////////////////////////////////////////////////////

    private function _crearUsuario($datos){
        return User::create([
            'idTipo' => 1,
            'email' => $datos['email'],
            'contrasena' =>  Hash::make($datos['contrasena']),
            'fechaRegistro' => Carbon::today(),
            'puntos'=> 0
        ]);
    }

    private function _crearPersonaFisica($idUsuario, $datos){
        return PersonaFisica::create([
            'idUsuario' => $idUsuario,
            'nombre'    => $datos['nombre'],
            'apellido'  => $datos['apellido'],
            'documento' => $datos['documento'],
            'sexo'      => $datos['sexo'],
            'fechaNacimiento'   => $datos['fechaNacimiento']
        ]);
    }

}
