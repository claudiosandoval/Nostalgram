<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth'); //Middleware para redireccionar al login si no esta logeado y accede a la ruta ImageController
    }

    public function create() {
        return view('image.create');
    }

    public function publicar(Request $request) {

        //Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|mimes:jpg,jpeg,gif' //La tuberia sirve para concatenar mas validaciones
            // 'image_path' => 'required|image' //Automaticamente la regla de validacion image de laravel valida que solo se puedan ingresar imagenes
        ]);

        
        
        $id_user = Auth::user()->id;
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        
        $image_path_name = time().$image_path->getClientOriginalName();
        

        //Asignar valores al objeto
        $image = new Image();
        $image->user_id = $id_user;
        $image->description = $description;
        
        
        if($image_path) {
            Storage::disk('images')->put($image_path_name, File::get($image_path)); //Agregamos la imagen al storage y con file metodo get lo captura y lo mueve a la carpeta storage
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with(array(
            'message' => 'La imagen se ha subido correctamente'
        ));

        // var_dump($image);
        // die();
    }
}
