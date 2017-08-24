(function($){
  if ($('body').hasClass('page-template-page-home')) {

    if (typeof $('.vc-membership-card') !== 'undefined') {
      $('.vc-membership-card').each(function(i){
        calculate_margin($('.vc-membership-card').eq(i));
        $(window).resize(function(){calculate_margin($('.vc-membership-card').eq(i));});
      });
    }
  }
  function calculate_margin(s) {
    var halfHeight = (s.outerHeight()/2);
    var newMargin = (halfHeight - 16 - 50);
    s.parents('.vc_column-inner').css('margin-top',newMargin);
    s.parents('.vc_row').prevAll('.vc_row').first().css('padding-bottom',halfHeight);
  }
})(jQuery);
