<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth'); // Middleware que redirecciona al login si este no esta identificado
    }
    
    public function saveComment(Request $request) {
        
        //Validacion de los comentarios
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'required|string'
        ]);
        
        //Recogemos los datos del formulario
        $user = \Auth::user();
        $image_id = $request->input('image_id'); //Capturamos el id de la imagen del input hidden que hemos creado
        $content = $request->input('content'); //Capturamos el comentario ingresado por el textarea con name "content"
        
        // var_dump($content);
        // die();

        //Asignar los valores recibidos al objeto comment
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        
        //Guardamos el objeto en la base de datos con los valores recogidos
        $comment->save();

        //Redireccion

        return redirect()->route('image.detail', ['id' => $image_id])->with(['message' => 'Has publicado tu comentario correctamente']);

    }
}
