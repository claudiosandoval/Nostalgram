<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Image;
use App\Like;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

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
            'image_path' => 'required|mimes:jpg,jpeg,gif,png' //La tuberia sirve para concatenar mas validaciones
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

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename); //metodo get de storage para obtener la imagen

        return new Response($file, 200); //Devuelve la imagen en una respuesta http
    }

    public function detail($id) {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        $user = \Auth::user();
        $image = Image::find($id); //Retorna el objeto con el id especificado

        //Sacar los likes y los comentarios antes de eliminar una imagen (Esto es para prevenir el mensaje de bd.. no se ha podido borrar debido a que hay registros asociados)
        //Integrudad referencial no dejará eliminar si existen registros en la tabla de likes y comentarios
        $comments = Comment::where('image_id', $id)->get(); //Retorna todos los comentarios asociados a la imagen
        $likes = Like::where('image_id', $id)->get(); //Retorna todos los likes asociados a la imagen

        if($user && $image && $image->user->id == $user->id) { //Si el user autenticado es igual al user id de la imagen entonces pasaremos a eliminar dicha imagen
            //Eliminar comentarios 
            if($comments && $comments >= '1') {
                foreach($comments as $comment) {
                    $comment->delete();
                }
            }

            //Eliminar likes

            if($likes && $likes >= '1') {
                foreach($likes as $like) {
                    $like->delete();
                }
            }

            //Eliminar ficheros asociados de imagen guardados en el storage
            Storage::disk('images')->delete($image->image_path);


            //Eliminar registro de la imagen

            $image->delete();

            $message = ['message' => 'La imagen ha sido eliminada correctamente'];
        }else {
            $message = ['message' => 'La imagen no pudo ser eliminada'];
        }

        return redirect()->route('home')->with($message);

    }
}
