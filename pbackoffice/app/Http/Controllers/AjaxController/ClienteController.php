<?php

namespace App\Http\Controllers\AjaxController;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected function ModificarCliente(Request $request){
        try{
            $datos = $request->all();
            $cliente = Cliente::findOrFail($datos['id']);
            $datosCliente = $cliente->datos;
            $this->modificarDatosCliente($datosCliente, $datos);
            $this->modificarUsuario($cliente, $datos);
            return response()->json(['respuesta' => 'Modificacion de cliente exitosa.'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }

    }

    private function modificarDatosCliente($datosCliente, $datos){
        if($datosCliente->documento != $datos['documento']){
            $datosCliente->documento = $datos['documento'];
            $datosCliente->save();
        }
    }

    private function modificarUsuario($cliente, $datos){
        $cliente->email = $datos['email'];
        $cliente->puntos = $datos['puntos'];
        $cliente->save();
    }
    
}
