jQuery(function($){

  $.fn.quicktoggle = function() {
    this.each(function() {
        var $this = $(this);
        if ($this.is(':visible')) {
            $this.hide();
        } else {
            $this.show().css('display','flex');
        }
    });
    return this;
};


  $('.menu-icon').click(function(){
    toggleItems();
  });
  $('.menu-icon-close').click(function(){
    $('.menu-icon').click();
  });
  function toggleItems() {
    $('.menu-icon').quicktoggle();
    $('body').toggleClass('display-mobile-menu');
    $('#style-mobile-menu').toggleClass('blue');
    $('.menu-icon-close').quicktoggle();
  }
  $(window).resize(function(){
    if( $('body').hasClass('display-mobile-menu') && $(window).width() >= 800 ) {
      $('.menu-icon').click();
      $('.menu-icon-close').hide();
    }
  });
});
