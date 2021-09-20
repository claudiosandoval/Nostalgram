<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    //
    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {

        //Conseguir usuario identificado
        $user= \Auth::user();
        $id = $user->id;

        //Validacion del formulario
        $validate = $this->validate($request, [ //Metodo heredado de laravel que valida el string que se pasa por parametro
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id], //validate en laravel es una forma potente de validar los campos, unique:users indica que solo puede haber un campo unico en la tabla users
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            // 'password' => ['required', 'string', 'min:6', 'confirmed'], //confirmed es para que sea igual en las 2 contraseñas
        ]);
        
        //Recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // var_dump($id);
        // var_dump($name);
        // var_dump($surname);
        // die();
        
        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Ejecutar consulta y cambios en la base de datos
        $user->update();
        return redirect()->route('config')->with(
            ['message' => 'Usuario actualizado correctamente']
        );
    }
}
