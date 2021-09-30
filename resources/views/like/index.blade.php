@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-3 text-secondary">Mis imagenes favoritas</h2>
            <hr>
            @foreach($likes as $like)
                <!-- Extendemos de la carpeta includes la maqueta de nuestra card para optimizar y reutilizar el codigo, de manera que le pasamos la variable imagen por medio de la vaiable $like de LikeController-->
                @include('includes.publicacion', ['image' => $like->image])
            @endforeach
        </div>
    </div>
    <!-- Paginacion  -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{ $likes->links() }}
        </div>
    </div>
</div>
@endsection