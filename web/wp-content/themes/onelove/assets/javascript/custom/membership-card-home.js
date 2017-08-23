(function($){
  if ($('body').hasClass('page-template-page-home')) {

    if (typeof $('.vc-membership-card') !== 'undefined') {
      $('.vc-membership-card').each(function(i){
        calculate_margin($(this));
        $(window).resize(function(){calculate_margin($(this));});
      });
    }
  }
  function calculate_margin(s) {
    var halfHeight = (s.outerHeight()/2);
    s.parent().css('margin-top',halfHeight-67.5);
    s.parents('.vc_row').prevAll('.vc_row').first().css('padding-bottom',halfHeight);
  }
})(jQuery);
