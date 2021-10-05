@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row perfil_usuario justify-content-center">
        <div class="col-10">
            @if($user->image)
            <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="">   
            @else
            <img src="{{ asset('images/no-disponible.jpg') }}" alt="sin imagen">
            @endif
            <!-- <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="foto_perfil"> -->
            <p class="nick">{{ $user->nick }}</p>
            <a href="{{ route('config') }}">Editar mi perfil</a>
        </div>
    </div>
    <div class="row">
        <div class="col-10 mx-auto">
            <!-- <h2 class="mb-3 text-secondary text-center">Mi perfil</h2> -->
            <hr>
            <div class="row perfil">
                @if(count($user->images) == 0)
                    <div class="container_publicacion col-12">
                        <h2 class="text-secondary text-center">No has realizado ninguna publicación</h2>
                    </div>
                @else
                    @foreach($user->images as $image)
                    <div class="container_publicacion col-4">
                        <img src="{{ route('get.publicacion', ['filename' => $image->image_path]) }}" alt="publicacion" class="publicacion">
                        <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="ver_publicacion">Ver publicacion</a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection