jQuery(function($){
  $('.menu-icon').click(function(){
    toggleItems();
  });
  $('.menu-icon-close').click(function(){
    $('.menu-icon').click();
  });
  function toggleItems() {
    $('.menu-icon-close').toggle();
    $('.menu-icon').toggle();
    $('body').toggleClass('display-mobile-menu');
  }
  $(window).resize(function(){
    if( $('body').hasClass('display-mobile-menu') && $(window).width() >= 800 ) {
      $('.menu-icon').click();
    }
  });
});
