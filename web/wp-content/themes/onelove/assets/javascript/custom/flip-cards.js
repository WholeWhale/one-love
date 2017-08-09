jQuery(function($){

  flip_card_grid();

  $('[data-flip-back]').click(function(){
    flip_card_grid(true);
  });

  $('[data-flip-front]').click(function(){
    flip_card_grid(false);
  })

  function flip_card_grid( flip_type ) {
    $('[data-flip-card]').each(function(i){
      var id = $(this).attr('id');
      $('#'+id).flip(flip_type);
    });
  }

});
