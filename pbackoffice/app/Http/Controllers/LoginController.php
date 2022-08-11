<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    protected function IniciarSesionView(){
        return view('Autenticacion.Login');
    }

    protected function IniciarSesion(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/dashboard');
        }
        else{
            return Redirect::back()->withErrors(['Las credenciales son incorrectas.']);
        }
    }

    Protected function CerrarSesion(){
        Auth::logout();
        return redirect("/inicioSesion");
    }
}
