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
                    <a href=""><i class="bi bi-heart"></i></a>
                    <a href=""><i class="bi bi-chat"></i></a>
                    
                    <a href="" class="float-right"><i class="bi bi-three-dots-vertical"></i></a>
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
                        @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id)) <!--  Auth::check() metodo que devuelve true si esta identificado / false -->
                        <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="delete_comment"><i class="bi bi-trash-fill"></i></a>
                        @endif
                        <p class="user_comment_fecha">{{ FormatTime::LongTimeFilter($comment->created_at) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="public_comentario">
                    <form action="{{ route('comment.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id=""  placeholder="Agrega un comentario..." ></textarea>
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
