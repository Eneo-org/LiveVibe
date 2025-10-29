// Funzione per gestire la risposta AJAX e aggiungere gli elementi al DOM

function handleAjaxResponse(responseText) {
    document.getElementById('container_mid').innerHTML = responseText; //per inserire gli eventi nel dom


    $(document).on('click', '.comment', function() {
        var containerPost = $(this).closest('.container_all');
        var eventId = $(this).closest('.container_post').data('event-id');
        console.log('commenti dell evento: '+ eventId);
        $.ajax({
            url: 'carica_commenti.php',
            type: 'GET',
            data: { eventId: eventId },
            success: function(response) {
                containerPost.find('.all_comments').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Errore durante il caricamento dei commenti:', error);
            }
        });
    });
    
  


    //gestione delle finestre evento e commenti 
    var commentIcon = document.getElementById('commentIcon');

    if (commentIcon) {
        $('.comment').click(function(){ 
            console.log('Icona chat cliccata'); 

            var containerPost = $(this).closest('.container_post');
            containerPost.find('.container_img').hide();
            containerPost.find('.container_info_post').hide();
            containerPost.find('.container_icons').hide();

            var containerComment = containerPost.find('.container_comment');
            containerComment.show();
        });
    }

  
    var arrow = document.getElementById('arrow');

    if (arrow) {
        $('.container_arrow').click(function(){
            console.log('Icona freccia cliccata'); 
            var containerPost = $(this).closest('.container_post');
            containerPost.find('.container_comment').hide();
            containerPost.find('.container_img').show();
            containerPost.find('.container_info_post').show();
            containerPost.find('.container_icons').show();
        });
    }
}
