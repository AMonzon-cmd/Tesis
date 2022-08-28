<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Rol;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class ModulosController extends Controller
{
    protected function Dashboard(){
        $dashboard = new stdClass();
        
        $dashboard->pagosDelDia = Pago::whereDate('created_at', Carbon::now())->where('estado', '!=', 'Anulado')->count();
        $dashboard->pagosTotales = Pago::where('estado', '!=', 'Anulado')->count();
        $dashboard->pagosAnulados = Pago::where('estado', 'Anulado')->count();
        $dashboard->clientesNuevos = Cliente::whereDate('created_at', Carbon::now())->whereNull('deleted_at')->count();
        return view("Dashboard", compact('dashboard'));
    }

    protected function AltaEmpleado(){
        $roles = Rol::whereNull('deleted_at')->get();
        return view("Usuarios.Empleados.ABMUsuario", compact("roles"));
    }

    protected function ModificarEmpleado($idUsuario){
        $roles = Rol::whereNull('deleted_at')->get();
        $usuario = Usuario::where('id', $idUsuario)->first();

        return view("Usuarios.Empleados.ABMUsuario", compact("roles", "usuario"));
    }

    protected function ListadoEmpleados(){
        $empleados = Usuario::all();
        return view("Usuarios.Empleados.ListadoEmpleados", compact("empleados"));
    }

    protected function ListadoClientes(){
        $clientes = Cliente::where('tipo', 1)->with('datos')->get();
        return view("Usuarios.Clientes.ListadoClientes", compact("clientes"));
    }

    protected function ModificarCliente($idUsuario){
        $usuario = Cliente::find($idUsuario);
        return view("Usuarios.Clientes.ModificarCliente", compact("usuario"));
    }

    protected function ListadoServicios(){
        $servicios = Servicio::all();
        return view("Servicios.ListadoServicios", compact("servicios"));
    }

    protected function ListadoPagos(){
        $pagos = Pago::all();
        return view('Pagos.ListadoPagos', compact('pagos'));
    }

    protected function ListarPagosCliente($idUsuario){
        $pagos = Pago::where('usuario_id', $idUsuario)->get();
        return view('Pagos.ListadoPagos', compact('pagos'));
    }

    protected function AltaProductoCatalogo(){
        return view('Productos.Producto');
    }
    
    
}
