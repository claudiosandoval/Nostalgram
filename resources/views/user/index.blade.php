@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row perfil_usuario justify-content-center">
        <div class="col-md-8">
            <div class="buscador mt-3">
                <h2 class="text-secondary titulo_buscador">Usuarios registrados</h2>
                <form class="form-inline my-2 my-lg-0 buscador_usuarios" method="GET" action="{{ route('user.index') }}" id="buscador"> 
                    <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Buscar" id="buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form> 
            </div>
            <div class="clearfix"></div>
            <hr>
            @foreach($users as $user)
            <div class="row perfil_usuario justify-content-center all_users">
                <div class="col-10">
                    @if($user->image)
                    <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="">
                    @else
                    <img src="{{ asset('images/no-disponible.jpg') }}" alt="sin imagen">
                    @endif
                    <!-- <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="foto_perfil"> -->
                    <div class="user_information">
                        @if($user->nick)
                        <a href="{{ route('user.perfil', ['id' => $user->id]) }}" class="nick">{{ $user->nick }}</a>
                        @else
                        <a href="{{ route('user.perfil', ['id' => $user->id]) }}" class="nick">Sin nombre</a>
                        @endif
                        <p class="Nombre">{{ $user->name.' '.$user->surname }}</p>
                        <p class="antiguedad">Se unio: {{ FormatTime::LongTimeFilter($user->created_at) }}</p>
                    </div>
                </div>
                
            </div>
            <hr>
            @endforeach

        </div>
    </div>
    <!-- Paginacion  -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection