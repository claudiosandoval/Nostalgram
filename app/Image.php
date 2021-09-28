<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table = 'images'; //Indica como se llama la tabla de la base de datos a utilizar

    //Relacion One to Many (De uno a muchos)

    //(Un solo modelo va a tener muchos comentarios)
    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc'); //Devolverá un array de objetos de todos los comentarios // Esto laravel lo realiza de manera programatica por de tras y realiza las consultas necesarias para traer la consulta
    }

    //Relacion One to Many (De uno a muchos)
    public function likes() {
        return $this->hasMany('App\Like'); //Devolverá el array de objetos donde el id de image corresponda con el like que intento sacar EJ: si saco una imagen con id 5 automaticamente cuando llame a likes sacara todos los likes cuando image_id es igual a 5
    }

    //Sacar el usuario que ha creado la imagen relacion muchos a 1 // muchas imagenes pueden tener 1 unico creador (usuario) MANY TO ONE

    public function user() {
        return $this->belongsTo('App\User', 'user_id'); //Devuelve el objeto mediante user_id //Buscara el id cuyo user_id de image coincida //SELECT * FROM INNER JOIN
    }

}
