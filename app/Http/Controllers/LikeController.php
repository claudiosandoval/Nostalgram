<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Image;

class LikeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth'); // Middleware que redirecciona al login si este no esta identificado
    }

    public function like($image_id) {
        //Recogre datos del usuario y la imagen para guardar ese like
        $user = \Auth::user(); //usuario que se encuentra en la session

        //Comprobar si el like ya existe
        
        $issetLike = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();

        
        // var_dump($issetLike);
        // die();


        if($issetLike == 0) { //Guardara el like solo si ya no existe en la base de datos para que no guarde mas de uno
            //Recoger y guardar likes
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id; //Casteamos el image_id a un entero ya que lo guarda como un string
            $like->save();

            return response()->json([ //Devolvemos un json para llamar este metodo por ajax y que no recarge la pagina
                'like' => $like,
                'count' => count($like->image->likes)
            ]); 
        }else {
            // echo "Ya existe el like";
            return response()->json([
                'message' => 'El like ya existe'
            ]); 
        }
    }

    public function dislike($image_id) {
        //Recogre datos del usuario y la imagen para guardar ese like
        $user = \Auth::user(); //usuario que se encuentra en la session

        //Comprobar si el like ya existe
        
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();

        $image = new Image();

        
        // var_dump($issetLike);
        // die();


        if($like) { //Si retorna el like, lo eliminamos

            //Eliminar like
            $like->delete();

            return response()->json([ //Devolvemos un json para llamar este metodo por ajax y que no recarge la pagina
                'like' => $like,
                'count' => count($like->image->likes),
                'message' => 'Has dado dislike'
            ]); 
        }else {
            // echo "Ya existe el like";
            return response()->json([
                'message' => 'El like no existe'
            ]); 
        }
    }

    public function index() {
        $likes = Like::orderBy('id', 'desc')->paginate(5);

        return view('like.index', [
            'likes' => $likes
        ]);
    }
}
