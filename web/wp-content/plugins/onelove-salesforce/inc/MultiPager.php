<?php

class MultiPager {
  public function addTag() {
    wpcf7_add_form_tag('pager', array($this, 'tagHandler'));
  }

  public function tagHandler() {
    return '<div class="ol-sf-pager"></div>';
  }

  public function enqueueScripts() {
    wp_enqueue_script(
  		'multipager',
  		plugins_url('multipager.js', __FILE__),
  		array('jquery'),
  		'1.0.0',
  		true
  	);
  }
}
