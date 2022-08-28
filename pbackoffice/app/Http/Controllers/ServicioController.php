<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ServicioController extends Controller
{

    private function validarServicio($datos){
        if(!isset($datos['nombre'])){
            throw new Exception('Debe ingresar un nombre para el servicio');
        }

        if(!isset($datos['logo'])){
            throw new Exception('Debe ingresar un logo para el servicio');
        }

        if(Servicio::where('nombre', $datos['nombre'])->exists()){
            throw new Exception('El nombre del servicio ya se encuentra utilizado');
        }


    }

    public function altaServicio(Request $request){
        try{
            $datos = $request->all();
            $this->validarServicio($datos);
            Servicio::create([
                'nombre' => $datos['nombre'],
                'descripcion' => isset($datos['descripcion']) ? $datos['descripcion'] : '',
                'logo'        => $datos['logo'],
            ]);
            return response()->json(['respuesta' => 'El servicio fue creado correctamente'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 400);
        }
    }

    public function modificarServicio(Request $request){
        try{
            $datos = $request->all();
            $servicio = Servicio::find($datos['id']);
            $this->validarServicioModificar($servicio, $datos);
            $this->ejecutarModificacion($servicio, $datos);
            return response()->json(['respuesta' => 'El servicio modificado correctamente'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 400);
        }
    }

    private function validarServicioModificar(Servicio $servicio = null, $datos){
        if(!$servicio){
            throw new Exception('El servicio a modificar no existe');
        }

        if(!isset($datos['nombre'])){
            throw new Exception('Debe ingresar un nombre para el servicio');
        }

        if(!isset($datos['logo'])){
            throw new Exception('Debe ingresar un logo para el servicio');
        }

        $servicioSimilar = Servicio::where('nombre', $datos['nombre'])->where('id', '!=', $datos['id'])->first();

        if($servicioSimilar){
            throw new Exception('El nombre del servicio ya se encuentra utilizado');
        }
    }

    private function ejecutarModificacion($servicio, $datos){
        $servicio->nombre = $datos['nombre'];
        $servicio->descripcion = $datos['descripcion'];
        $servicio->logo = $datos['logo'];
        $servicio->save();
    }


    public function alternarEstadoServicio(Request $request){
        try{
            $datos = $request->all();
            $servicio = Servicio::findOrFail($datos['id']);

            $servicio->deleted_at = ($servicio->deleted_at == null) ? Carbon::now() : null;
            $servicio->save();

            return response()->json(['respuesta' => 'Se realizo el cambio de estado en el servicio.', 'servicio' => $servicio], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }
}
