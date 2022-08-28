<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = array(
            array(
                'tipo' => 'Persona Fisica',
                'email'=> 'cliente1@hotmail.com',
                'pass' => Hash::make('prueba123'),
            ),
            array(
                'tipo' => 'Persona Fisica',
                'email'=> 'cliente2@hotmail.com',
                'pass' => Hash::make('prueba123'),
            ),
            array(
                'tipo' => 'Persona Fisica',
                'email'=> 'cliente3@hotmail.com',
                'pass' => Hash::make('prueba123'),
            )
        );


        $datos = array(
            array(
                'idUsuario' => 1,
                'nombre'    => 'Jorge',
                'apellido'  => 'Sistema',
                'documento' => '111111111',
                'sexo'      => 'masculino',
                'fechaNacimiento' => '1990-10-01'
            ),
            array(
                'idUsuario' => 2,
                'nombre'    => 'Antonio',
                'apellido'  => 'Sistema',
                'documento' => '222222222',
                'sexo'      => 'masculino',
                'fechaNacimiento' => '1990-10-01'
            ),
            array(
                'idUsuario' => 3,
                'nombre'    => 'Alicia',
                'apellido'  => 'Sistema',
                'documento' => '333333333',
                'sexo'      => 'femenino',
                'fechaNacimiento' => '1990-10-01'
            )
        );

        foreach ($clientes as $key => $cliente) {
            DB::table('Usuarios')->insert([
                'tipo' => $cliente['tipo'],
                'email' => $cliente['email'],
                'contrasena' => $cliente['pass']
            ]);
        }

        foreach ($datos as $key => $dato) {
            DB::table('PersonasFisicas')->insert([
                'idUsuario' => $dato['idUsuario'],
                'nombre' => $dato['nombre'],
                'apellido' => $dato['apellido'],
                'documento' => $dato['documento'],
                'sexo' => $dato['sexo'],
                'fechaNacimiento' => $dato['fechaNacimiento'],
            ]);
        }

        DB::table('UsuariosBackoffice')->insert([
            'email' => 'clferreri@payday.com',
            'pass'  => Hash::make('Cristian123'),
            'nombre' => 'Cristian',
            'apellido' => 'Ferreri',
            'documento' => '51294519',
            'rol_id' => 1
        ]);

    }
}
