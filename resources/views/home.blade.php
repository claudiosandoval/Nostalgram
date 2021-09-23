@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')
            @foreach($images as $image)
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
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="comentarios">
                        <p>Ver los {{ count($image->comments) }} comentarios</p>
                    </a>        
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Paginacion  -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{ $images->links() }}
        </div>
    </div>
</div>
@endsection
