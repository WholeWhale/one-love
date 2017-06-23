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
});
