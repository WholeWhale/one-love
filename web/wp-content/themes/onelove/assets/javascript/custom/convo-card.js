(function($){

  var positionCard = (function calculate() {

      var card = $(".card-half").eq(0);
      var maxHeight = card.height('100%').height()+55;
      var convo_height = $(".conversation-card").outerHeight();

      if ( $(window).width() < 800 ) maxHeight += 45;

      $(".conversation-card").css({
        "transform":"translateY(-"+maxHeight+"px)",
        "margin-bottom": -( convo_height ),
      }).next().find(".entry-content > *:first-child").css({
        "z-index": "-1",
        "padding-top": convo_height - maxHeight + 10,
      });
      return calculate;
  }());
  $(window).resize(positionCard);

})(jQuery);
