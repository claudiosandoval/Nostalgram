<div class="card">
    <div class="card-header" style="background-color:white">
        @if($image->user->image)
        <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" alt="" class="avatar_inicio">
        @else
        <img src="{{ asset('images/no-disponible.jpg') }}" alt="sin imagen" class="avatar_inicio">
        @endif
        <a href="{{ route('user.perfil', ['id' => $image->user->id]) }}"><span class="nick_inicio">{{ $image->user->nick }}</span></a>
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
        @if(Auth::user() && Auth::user()->id == $image->user->id)
        <i class="bi bi-three-dots-vertical float-right" style="color:grey; cursor:pointer" data-toggle="modal" data-target="#modal_detail_publicacion{{ $image->id }}"></i>

        <!-- Modal -->
        <div class="modal fade modal_detail_publicacion" id="modal_detail_publicacion{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <ul>
                            <li><a href="{{ route('image.edit', ['id' => $image->id]) }}">Editar publicación</a></li>
                            <!-- <li><a href="{{ route('image.delete', ['id' => $image->id]) }}" class="text-danger">Borrar Publicación</a></li> -->
                            <li><a href="" data-toggle="modal" data-target="#modal_advertencia{{ $image->id }}" class="text-danger">Borrar publicación</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Advertencia-->
        <div class="modal fade modal_detail_advertencia" id="modal_advertencia{{ $image->id }}" tabindex="-1" aria-labelledby="modal_advertencia" aria-hidden="true">
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
        <span class="nick"><a href="{{ route('user.perfil', ['id' => $image->user->id]) }}">{{ $image->user->nick }}</a></span>
        <span class="texto">{{ $image->description }}</span>
        <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="comentarios">
            @if(count($image->comments) == 1)
            <p>Ver comentario</p>
            @elseif(count($image->comments) > 1)
            <p>Ver los {{ count($image->comments) }} comentarios</p>
            @elseif(count($image->comments) == 0)
            <p></p>
            @endif
        </a>
    </div>
</div>