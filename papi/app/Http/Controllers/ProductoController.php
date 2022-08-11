<?php

namespace App\Http\Controllers;

use App\Models\ProductoCatalogo;
use App\Models\ReclamoProducto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function listarProductos($productoId = null){
        try{
            if ($productoId){
                $producto = ProductoCatalogo::findOrFail($productoId);
                return response()->json(['respuesta' => 'Producto de catalogo obtenido correctamente', 'producto' => $producto], 200);
            }else{
                return response()->json(['respuesta' => 'Productos obtenidos correctamente', 'productos' => ProductoCatalogo::where('deleted_at',null)->get()], 200);
            }        
        }catch(Exception $e){
            return response()->json(['respuesta' => 'No se pudieron obtener los productos. Contacte a soporte'], 500);
        }
    }

    public function reclamarProducto($productoId){
        try{
            $producto = ProductoCatalogo::findOrFail($productoId);
            if($producto->stock <= 0){
                return response()->json(['respuesta' => 'No tenemos mas stock del producto seleccionado'], 400);
            }
            $usuario = User::find(Auth::user()->id);
            if($usuario->puntos < $producto->costo){
                return response()->json(['respuesta' => 'No posee saldo suficiente para reclamar el producto'], 400);
            }

            ReclamoProducto::create([
                'usuario_id' => $usuario->id,
                'producto_id'    => $producto->id,
                'puntos_usuario'  => $usuario->puntos,
                'puntos_producto' => $producto->costo
            ]);

            $usuario->puntos -= $producto->costo;
            $usuario->save();

            //MANDO EMAIL;

            return response()->json(['respuesta' => 'Producto de catalogo reclamado', 'producto' => $producto], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'No se pudieron obtener los productos. Contacte a soporte'], 500);
        }
    }

    public function listarProductosUsuario($idUsuario){
        try{
            if (!$idUsuario){
                return response()->json(['respuesta' => 'No se pueden obtener los productos', 'productos' => ''], 400);
            }  
            $productos = "";
            return response()->json(['respuesta' => 'Productos reclamados obtenidos', 'productos' => $productos], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'No se pudieron obtener los productos. Contacte a soporte'], 500);
        }
    }
}
