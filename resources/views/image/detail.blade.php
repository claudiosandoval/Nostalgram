@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')
            <div class="card">
                <div class="card-header" style="background-color:white">
                    @if($image->user->image)
                    <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" alt="" class="avatar_inicio">
                    @else
                    <img src="{{ asset('images/no-disponible.jpg') }}" alt="sin imagen" class="avatar_inicio">
                    @endif
                    <a href=""><span class="nick_inicio">{{ $image->user->nick }}</span></a>
                    <!-- @if(date('i') - date_format($image->created_at, 'i') == 1 && date('H') - date_format($image->created_at, 'H') == 0)
                    <p class="fecha_publicacion">Hace {{ date('i') - date_format($image->created_at, 'i') }} Minuto </p>
                    @elseif(date('i') - date_format($image->created_at, 'i') <= 59 && date('H') - date_format($image->created_at, 'H') == 0)
                    <p class="fecha_publicacion">Hace {{ date('i') - date_format($image->created_at, 'i') }} Minutos </p>
                    @elseif(date('H') - date_format($image->created_at, 'H') == 1 && date('d') - date_format($image->created_at, 'd') < 1)
                    <p class="fecha_publicacion">Hace {{ date('H') - date_format($image->created_at, 'H') }} Hora </p>
                    @elseif(date('H') - date_format($image->created_at, 'H') <= 23 && date('d') - date_format($image->created_at, 'd') < 1)
                    <p class="fecha_publicacion">Hace {{ date('H') - date_format($image->created_at, 'H') }} Horas </p>
                    @elseif(date('d') - date_format($image->created_at, 'd') == 1)
                    <p class="fecha_publicacion">Hace {{ date('d') - date_format($image->created_at, 'd') }} día </p>
                    @else
                    <p class="fecha_publicacion">Hace {{ date('d') - date_format($image->created_at, 'd') }} días </p>
                    @endif -->
                    <p class="fecha_publicacion">{{ FormatTime::LongTimeFilter($image->created_at) }}</p>
                </div>
                <div class="card-body container_publicacion">
                    <img src="{{ route('get.publicacion', ['filename' => $image->image_path]) }}" alt="publicacion" class="publicacion">
                </div>
                <div class="acciones_publicacion">
                    <!-- Comprobar si el usuario le dio like a la publicacion  -->
                    <?php $user_like = false ?>
                    @foreach($image->likes as $like)
                    @if($like->user->id == Auth::user()->id)
                    <?php $user_like = true ?>
                    @endif
                    @endforeach

                    @if($user_like)
                    <i class="bi bi-heart-fill heart_red btnlike" data-id="{{ $image->id }}"></i>
                    @else
                    <i class="bi bi-heart-fill btndislike" data-id="{{ $image->id }}"></i>
                    @endif
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}"><i class="bi bi-chat-fill"></i></a>
                    <!-- Comprobar si el usuario puede o no eliminar su publicacion  -->
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <i class="bi bi-three-dots-vertical float-right" style="color:grey; cursor:pointer" data-toggle="modal" data-target="#modal_detail_publicacion"></i>

                    <!-- Modal -->
                    <div class="modal fade modal_detail_publicacion" id="modal_detail_publicacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <ul>
                                        <li><a href="{{ route('image.edit', ['id' => $image->id]) }}">Editar publicación</a></li>
                                        <!-- <li><a href="{{ route('image.delete', ['id' => $image->id]) }}" class="text-danger">Borrar Publicación</a></li> -->
                                        <li><a href="" data-toggle="modal" data-target="#modal_advertencia" class="text-danger">Borrar publicación</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Advertencia-->
                    <div class="modal fade modal_detail_advertencia" id="modal_advertencia" tabindex="-1" aria-labelledby="modal_advertencia" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">¿Eliminar esta publicación?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p style="font-size:16px">Esta publicación se eliminará definitivamente.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <a type="button" href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Borrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="me_gusta">
                        <p class="count_likes" id="likes{{ $image->id }}">{{ count($image->likes) }} Me gusta</p>
                    </div>
                    <hr>
                </div>
                <div class="descripcion">
                    <span class="nick"><a href="">{{ $image->user->nick }}</a></span>
                    <span class="texto">{{ $image->description }}</span>
                </div>
                <div class="comentarios">
                    <hr>
                    @foreach($image->comments as $comment)
                    <div class="comment_user">
                        <span class="comment_nick">{{ $comment->user->nick }}: </span><span>{{ $comment->content }}</span>
                        @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                        <!--  Auth::check() metodo que devuelve true si esta identificado / false -->
                        <button class="delete_comment" data-toggle="modal" data-target="#modalEliminarComentario{{ $comment->id }}"><i class="bi bi-trash-fill"></i></button>
                        @endif
                        <p class="user_comment_fecha">{{ FormatTime::LongTimeFilter($comment->created_at) }}</p>
                    </div>
                    <!-- Modal eliminar comentario -->
                    <div class="modal fade" id="modalEliminarComentario{{ $comment->id }}" tabindex="-1" aria-labelledby="modalEliminarComentario" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Desea eliminar el comentario? {{ $comment->id }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" type="button" class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin modal eliminar -->
                    @endforeach
                </div>
                <div class="public_comentario">
                    <form action="{{ route('comment.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="" placeholder="Agrega un comentario..."></textarea>
                        @if ($errors->has('content'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                        @endif
                        <button class="form-control" class="button_public_comment" type="submit">Publicar</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection