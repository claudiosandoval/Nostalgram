<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        
        //Subir la imagen del usuario
        $image_path = $request->file('image_path');

        if($image_path) { //comprobamos que nos llegue la imagen y utilizamos un objeto de laravel llamado storage (debemos importarlo en use)
            $image_path_name = time().$image_path->getClientOriginalName(); //Utilizamos time para que sea un nombre unico en el caso de que los dos nombres sean iguales con time() funcion seran todos diferentes
            Storage::disk('users')->put($image_path_name, File::get($image_path)); //De esta manera con disk accedemos a la carpeta users de la carpeta storage y con put guardamos esa imagen la cual necesita el nombre de la imagen original y el recurso(resource) del archivo

            //Setear el nombre de la imagen path del objeto
            $user->image = $image_path_name;
        }
        // var_dump($image_path);
        // die();

        
        //Ejecutar consulta y cambios en la base de datos
        $user->update();
        return redirect()->route('config')->with(
            ['message' => 'Usuario actualizado correctamente']
        );
    }
}
