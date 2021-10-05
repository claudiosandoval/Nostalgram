<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use App\Image;


Route::get('/', function () {
    //Pruebas
    // $images = Image::all(); //Devuelve un array de objeto con todos los datos de la base de datos de la tabla images
    // $comentarios = Comment::all();
    
    // foreach ($images as $image) {
        
    //     echo $image->user->name.' '.$image->user->surname;
    //     echo '<br>';
    //     echo $image->description;
    //     var_dump($images);
        
    //     echo '<br>';
    //     echo '<br>';
        
    //     if(count($image->comments) >= 1) {
    //         echo '<strong> Comentarios: </strong>';

    //         foreach($image->comments as $comment) {
    //             echo '<br>';
    //             echo $comment->user->name;
    //             echo ' ';
    //             echo $comment->user->surname;
    //             echo ': ';
    //             echo $comment->content;
    //         }
    //     }
    //     echo '<br>';    
    //     echo 'Likes: '.count($image->likes);
    //     echo '<hr>';
    // }

    // die();

    return view('welcome');
});



Auth::routes(); //Routa creada con el comando php artisan make:auth (crea las rutas necesarias para los controladores de la carpeta auth)

Route::get('/', 'HomeController@index')->name('home'); //Ruta del inicio de la pagina

//Configuracion de usuario
Route::get('/user/index/{search?}', 'UserController@index')->name('user.index');
Route::get('/configuracion', 'UserController@config')->name('config'); //El name es el nombre de la ruta que es llamada en los enlaces como {{ route('nombre') }}
Route::post('/user/update', 'UserController@update'); //Actualiza el usuario
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar'); //Obtiene la imagen para el avatar del perfil de usuario
Route::get('/perfil/{id}', 'UserController@perfil')->name('user.perfil'); //Redirige a la vista de mi perfil con las publicaciones del usuario identificado

//Publicar foto 
Route::get('/image/public', 'ImageController@create')->name('image.public'); //Ruta que retorna la vista para publicar una foto
Route::post('/image/save', 'ImageController@publicar')->name('image.save'); //Ruta para guardar la foto subida
Route::get('/image/{filename}', 'ImageController@getImage')->name('get.publicacion'); //Obtener imagen para mostrar en las vistas mediante el nombre de ruta de la imagen (revisar controlador)
Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail'); //Retorna la vista de detalle de la imagen

//Gestionar publicacion
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete'); //Eliminar una foto
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit'); //Editar una foto
Route::post('/image/update', 'ImageController@update')->name('image.update'); //Actualizar la foto

//Comentarios
Route::post('/comment/save', 'CommentsController@saveComment')->name('comment.save'); //Guarda un comentario
Route::get('/comment/delete/{id}', 'CommentsController@deleteComment')->name('comment.delete'); //Elimina un comentario

//Likes
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save'); //Metodo para dar like a una publicacion
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete'); //Metodo para dar dislike a una publicacion
Route::get('/likes', 'LikeController@index')->name('like.index'); //Muestra todas las publicaciones a las que hemos dado like
