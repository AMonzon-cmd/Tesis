<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function listarServicios($userId = null){
        try{
            if ($userId){
                $usuario = User::findOrFail($userId);
                return response()->json(['respuesta' => 'Servicios del cliente obtenidos correctamente', 'servicios' => $usuario->servicios], 200);
            }else{
                return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'servicios' => Servicio::where('deleted_at',null)->get()], 200);
            }        
        }catch(Exception $e){
            return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'servicios' => Servicio::where('deleted_at',null)->get()], 200);
        }
    }

    public function pagarServicio(Request $request){
        $datos = $request->all();

        
    }
}
