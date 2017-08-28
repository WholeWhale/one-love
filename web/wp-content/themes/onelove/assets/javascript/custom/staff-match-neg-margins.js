(function($){
  $(window).bind('load resize orientationChange', function () {
    var footerMargin = $('#footer-container').css('marginTop');
    $('.staff-container').attr('style','margin-bottom: -'+footerMargin);
  });
})(jQuery);
