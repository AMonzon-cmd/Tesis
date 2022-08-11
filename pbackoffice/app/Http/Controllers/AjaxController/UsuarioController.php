<?php

namespace App\Http\Controllers\AjaxController;

use App\Http\Controllers\Controller;
use App\Modelos\PersonaEmpleado;
use App\Models\Usuario;
use App\User;
use App\Utilidades\Constantes;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    protected function AltaEmpleado(Request $request){
        $datos = $request->all();
        // if(!Auth::user()->tienePermiso('alta_empleado')){
        //     return response()->json(['respuesta' => 'No tiene Permisos.'], 400);
        // }
        $this->ValidarDatosEmpleado($datos);
        if ($this->CrearUsuarioEmpleado($datos) != null){
            return response()->json(['respuesta' => 'Alta de usuario exitosa.'], 200);
        }else{
            return response()->json(['respuesta' => 'No se pudo realizar el alta.'], 500);
        }

    }

    protected function ModificarEmpleado(Request $request){
        try{
            $datos = $request->all();
        
            $empleadoModificar = Usuario::findOrFail($datos['id']);
            
            $this->validarDatosModificar($empleadoModificar, $datos);
            $this->modificarDatos($empleadoModificar, $datos);
            return response()->json(['respuesta' => 'Modificacion de usuario exitosa.'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMEssage()], 500);
        }
    }

    private function validarDatosModificar($empleadoModificar, $datos){
        if($empleadoModificar->email != $datos['email']){
            $empleadoTmp = Usuario::where('email', $datos['email'])->first();

            if($empleadoTmp){
                throw new Exception('El email ya esta siendo utilizado');
            }
        }

        if($empleadoModificar->documento != $datos['documento']){
            $empleadoTmp2 = Usuario::where('documento', $datos['documento'])->first();
            if($empleadoTmp2){
                throw new Exception('El documento ya esta siendo utilizado');
            }
        }
    }

    private function modificarDatos($empleadoModificar, $datos){
        $empleadoModificar->email = $datos['email'];
        $empleadoModificar->nombre = $datos['nombre'];
        $empleadoModificar->apellido = $datos['apellido'];
        $empleadoModificar->documento = $datos['documento'];
        $empleadoModificar->rol_id = $datos['rol'];
        $empleadoModificar->save();
    }

    protected function ValidarDatosEmpleado($datos){
        return Validator::make($datos, [
            'email' => ['required', 'unique:UsuariosBackoffice,email','email:rfc,dns'],
            'nombre' => ['required'],
            'documento' => ['required', 'numeric', 'unique:UsuariosBackoffice,documento'],
            'fechaNacimiento' => ['required'],
            'rol' => ['required'],
        ])->validate(); 
    }

    protected function CrearUsuarioEmpleado(array $datos){
        $usuario = Usuario::create([
            'email' => $datos['email'],
            'pass' =>  Hash::make('WelcomePayDay2020'),
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'documento'=> $datos['documento'],
            'rol_id' => $datos['rol'],
            'usuario_genera_id' => Auth::user()->id,
        ]);

        return $usuario;
    }

    // public function GenerarPersonaEmpleado(int $idUsuario,array $datos){
    //     $empleado = PersonaEmpleado::create([
    //         'IdUsuario' => $idUsuario,
    //         'Nombre' => $datos['nombre'],
    //         'Apellido' => $datos['apellido'],
    //         'Documento' => $datos['documento'],
    //         'Sexo' => $datos['sexo'],
    //         'FechaNacimiento' => $datos['fechaNacimiento'],
    //         'IdRol' => $datos['rol'],
    //     ]);
    // }
}
