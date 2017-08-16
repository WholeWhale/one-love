jQuery(function($){

  $.fn.quicktoggle = function() {
    this.each(function() {
        var $this = $(this);
        if ($this.is(':visible')) $this.hide();
        else $this.show().css('display','flex');
    });
    return this;
  };
  function toggleItems() {
    $('.menu-icon-container,.menu-icon-close').quicktoggle();
    $('body').toggleClass('display-mobile-menu');
  }
  function homepage_color_reveal() {
    if ( $('.page-template-page-home').length ) {
      $(window).scroll(function(){
        if ( $(this).scrollTop() > 300 ) {
          $('body').removeClass('header-transparent');
        }
        else {
          $('body').addClass('header-transparent');
        }
      });
    }
  }

  homepage_color_reveal();

  $('.menu-icon, .menu-icon-close').click(toggleItems);

  $(window).resize(function(){
    if( $('body').hasClass('display-mobile-menu') && $(window).width() >= 800 ) {
      $('.menu-icon').click();
      $('.menu-icon-close').hide();
    }
  });
});
