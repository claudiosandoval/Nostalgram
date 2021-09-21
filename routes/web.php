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



Auth::routes(); 

Route::get('/', 'HomeController@index')->name('home');

//Configuracion de usuario
Route::get('/configuracion', 'UserController@config')->name('config'); //El name es el nombre de la ruta que es llamada en los enlaces como {{ route('nombre') }}
Route::post('/user/update', 'UserController@update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

//Publicar foto 
Route::get('/image/public', 'ImageController@create')->name('image.public');
Route::post('/image/save', 'ImageController@publicar')->name('image.save');
