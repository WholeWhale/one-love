<?php
/*

Plugin Name:  One Love Salesforce Integration
Description:  integrates SF with WP
Version:      1.0
Author:       @cjcodes
Author URI:   https://cj.codes

*/

require_once dirname(__FILE__) . '/inc/ContactChecker.php';
require_once dirname(__FILE__) . '/inc/Metaboxes.php';

class OneloveSalesforce {

  /**
   * Constructor
   */
  function __construct() {
    add_action('init', array($this, 'init'));
    add_action('load-post.php', array(new Metaboxes, 'setup'));
    add_action('load-post-new.php', array(new Metaboxes, 'setup'));
  }

  /**
   * add_action('init')
   */
  public function init() {
    $cc = new ContactChecker();
  }
}

new OneloveSalesforce;
