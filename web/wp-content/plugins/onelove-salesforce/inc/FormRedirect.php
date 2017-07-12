<?php

class FormRedirect {
  public function addTag() {
    wpcf7_add_form_tag('redirect', array($this, 'tagHandler'));
  }

  public function tagHandler($tag) {
    $path = $tag->values[0];

    if ($path[0] != '/' && substr($path, 0, 4) !== 'http') {
      $path = '/' . $path;
    }

    return <<<SCRIPT
    <script>
      document.addEventListener('wpcf7mailsent', function() {
        document.location = '$path';
      }, false );
    </script>
SCRIPT;
  }
}
