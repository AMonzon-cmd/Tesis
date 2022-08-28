<?php

namespace App\Http\Controllers;

use App\Http\Requests\AltaPago;
use App\Models\Moneda;
use App\Models\Pago;
use App\Models\ServicioAgendado;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagosController extends Controller
{
    protected function listarPagosUsuario($idUsuario){
        try {
            if(!$idUsuario){
                throw new Exception("No se pudieron obtener los pagos. Contacte a soporte", 1);
            }
            $pagos = Pago::where('usuario_id', $idUsuario)->get();
            return response()->json(['respuesta' => 'Pagos obtenidos correctamente', 'pagos' => $pagos], 200);
        } catch(Exception $e){
            return response()->json(['respuesta' => 'No se pudieron obtener los pagos. Contacte a soporte'], 500);
        }
    }

    protected function relizarPago(AltaPago $request){
        try {
            DB::beginTransaction();
            $datos = $request->all();
            $pago = $this->_realizarPago($datos);
            $this->_actualizarPuntaje($pago);
            $this->_agendarServicio($datos['idServicio']);
            $pago->notificar();
            DB::commit(); 
            return response()->json(['respuesta' => 'Pago realizado correctamente.'],200);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(['respuesta' => $th->getMessage()], 500);
        }
    }

    private function _realizarPago(array $datos){
        return Pago::create([
            'usuario_id'        => Auth::user()->id,
            'servicio_id'       => $datos['idServicio'],
            'moneda_id'         => $datos['moneda'],
            'monto'             => $datos['monto'],
            'estado'            => 'Confirmado',
            'medio_de_pago_id'  => null
        ]);
    }

    private function _actualizarPuntaje(Pago $pago){
        $usuario = User::findOrFail($pago->usuario_id);
        $puntajeGenerado = $pago->determinarPuntosGenerados();
        $usuario->puntos += $puntajeGenerado;
        $usuario->save();
        $pago->puntaje_generado = $puntajeGenerado;
        $pago->save();
    }

    private function _agendarServicio($idServicio){
        $servicioAgendado = ServicioAgendado::where('idUsuario', Auth::user()->id)->where('idServicio', $idServicio)->first();

        if(!$servicioAgendado){
            ServicioAgendado::create([
                'idUsuario' => Auth::user()->id,
                'idServicio' => $idServicio
            ]);
        }
    }
}
