jQuery(function($){

  // set stacked divs to be equal height
  function matchHeights() {
    var maxHeight = 0;
    $(".card-half").each(function(){
       if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
    });
    $(".card-half").eq(0).height(maxHeight+70);

  }
  function translate_margin() {
    var convo_card =  $('.conversation-card');
    var convo_card_height = convo_card.height();

    convo_card.css('margin-bottom',-( convo_card_height/2 ) );
  }

  matchHeights();
  translate_margin();

  // on resize, recalculate the natural height of the
  // of each div then rematch the heights.
  $(window).resize(function(){
    $(".card-half").height('100%'); // matchHeights logic fails if it already set the height of both to be equal
    matchHeights();
    translate_margin();
  });
});
