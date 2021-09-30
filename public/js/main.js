var url = 'http://www.nostalgram.com.devel/'

window.addEventListener("load", function() {
    // alert("La pagina esta totalmente cargada");
    // $('body').css('background', 'red');
    // console.log(document.querySelector('.btnlike'));
    // var btnlike = $('.btnlike');
    // console.log($('.btnlike'));
    $('.btnlike').css('cursor', 'pointer');
    $('.btndislike').css('cursor', 'pointer');

    //Boton de like
    function like() {
        $('.btndislike').unbind('click').on('click', function(e) {
            console.log("diste like");
            $(this).addClass('btnlike').removeClass('btndislike').toggleClass('heart_red');

            //Recogemos el id de la imagen con un atributo en el icono
            var imagen_id = $(this).attr('data-id');
            console.log(imagen_id);

            //Recogemos el id del contador de likes y actualizarlo en la respuesta del ajax (El contador llega por la respuesta ajax json de LikeController)
            var contador_likes = $('#likes' + imagen_id);
            console.log(contador_likes);

            $.ajax({
                url: url+'/like/'+imagen_id,
                type: 'GET',
                success: function(response) {
                    if(response.like) {
                        console.log('Has dado like a la publicacion');  
                        contador_likes.text(response.count + ' Me gusta');
                    }else { 
                        console.log('Error al dar like');
                    }
                    console.log(response);
                }
            })

            dislike();
        });
    }

    //Boton de dislike
    function dislike() { 
        $('.btnlike').unbind('click').on('click', function(e) {
            console.log("diste dislike");
            $(this).addClass('btndislike').removeClass('btnlike').toggleClass('heart_red');

            // console.log($('.btnlike').attr('data_id'));
            
            //Recogemos el id de la imagen con un atributo en el icono
            var imagen_id = $(this).attr('data-id');
            console.log(imagen_id);

            //Recogemos el id del contador de likes y actualizarlo en la respuesta del ajax (El contador llega por la respuesta ajax json de LikeController)
            var contador_likes = $('#likes' + imagen_id);
            console.log(contador_likes);

            $.ajax({
                url: url+'/dislike/'+imagen_id,
                type: 'GET',
                success: function(response) {
                    if(response.like) {
                        console.log('Has dado dislike a la publicacion');
                        contador_likes.text(response.count + ' Me gusta');
                    }else { 
                        console.log('Error al dar dislike');
                    }
                    console.log(response);
                }
            })

            like();
        });
    } 
    
    
    

    //Invocamos las funciones like y dislike
    like();
    dislike();
    
});