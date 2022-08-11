<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id', 'servicio_id', 'moneda_id', 'monto', 'estado', 'medio_de_pago_id'
    ];


    public function determinarPuntosGenerados()
    {
        $porcentajePuntaje = env('PORCENTAJE_PUNTAJE');
        $montoGeneraPuntaje = $this->monto;
        if ($this->moneda_id != env('MONEDA_PESO')){
            $cotizacionActual = CotizacionMoneda::where('moneda_id', $this->moneda_id)->orderBy('created_at', 'desc')->first();
            $montoGeneraPuntaje = $cotizacionActual->venta * $this->monto;
        }

        return $montoGeneraPuntaje * $porcentajePuntaje;
    }

    public function notificar()
    {
        $usuario = User::findOrFail($this->usuario_id);
        //Enviar Email a $usuario->email;
        return true;
    }
}
