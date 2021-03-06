<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';

    //Relacion muchos a 1
    public function user() {
        return $this->belongsTo('App\User', 'user_id'); //Devuelve el objeto mediante user_id //Buscara el id cuyo user_id de comment coincida
    }

    //Relacion muchos a 1
    public function image() {
        return $this->belongsTo('App\Image', 'image_id'); //Devuelve el objeto mediante user_id //Buscara el id cuyo user_id de comment coincida
    }
}
