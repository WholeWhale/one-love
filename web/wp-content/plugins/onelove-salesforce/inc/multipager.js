
jQuery(function($){
  var animationDelay = 100;

  var $pagers = $('.ol-sf-pager');
  var $form = $pagers.parents('form');
  var formOffsetTop = $form.offset().top;
  var $wrapper = $('<div class="paged">');
  var $workingWrapper = $wrapper.clone();
  var $e;

  $form.children().each(function (i, e) {
    $e = $(e);
    if ($e.hasClass('ol-sf-pager')) {
      $e.remove();
      $form.append($workingWrapper);
      $workingWrapper = $wrapper.clone();
    } else {
      $workingWrapper.append($e);
    }
  });

  $form.append($workingWrapper);

  var $pages = $('.paged');

  var $nextButton = $('<input type="button" value="Next" />').click(nextPage);
  var $backButton = $('<input type="button" value="Back" />').click(prevPage);

  $pages.not(':first').hide().append($backButton);
  $pages.not(':last').append($nextButton);

  function nextPage() {
    var $currentPage = $pages.not(':hidden');
    $pages.fadeOut(animationDelay);
    $currentPage.next().delay(animationDelay).fadeIn();
    scrollTop();
  }

  function prevPage() {
    var $currentPage = $pages.not(':hidden');
    $pages.fadeOut(animationDelay);
    $currentPage.prev().delay(animationDelay).fadeIn();
    scrollTop();
  }

  function scrollTop() {
    $('html, body').scrollTop(formOffsetTop - 50);
  }
});
