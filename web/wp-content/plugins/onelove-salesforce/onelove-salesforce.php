<?php
/*

Plugin Name:  One Love Salesforce Integration
Description:  integrates SF with WP
Version:      1.0
Author:       @cjcodes
Author URI:   https://cj.codes

*/

require_once dirname(__FILE__) . '/inc/Salesforce.php';
require_once dirname(__FILE__) . '/inc/ContactChecker.php';
require_once dirname(__FILE__) . '/inc/Metaboxes.php';
require_once dirname(__FILE__) . '/inc/RestHandler.php';
require_once dirname(__FILE__) . '/inc/MultiPager.php';
require_once dirname(__FILE__) . '/inc/OpportunitySelector.php';
require_once dirname(__FILE__) . '/inc/HiddenUserSelector.php';

class OneloveSalesforce {

  /**
   * Constructor
   */
  function __construct() {
    add_action('init', array($this, 'init'));
    add_action('load-post.php', array(new Metaboxes, 'setup'));
    add_action('load-post-new.php', array(new Metaboxes, 'setup'));
    add_action('rest_api_init', array(new RestHandler, 'setup'));
    add_action('wp_enqueue_scripts', array($this, 'autocompleteEnqueues'));
    add_action('wpcf7_init', array($this, 'addTag'));

    $multipager = new Multipager;
    add_action('wpcf7_init', array($multipager, 'addTag'));
    add_action('wp_enqueue_scripts', array($multipager, 'enqueueScripts'));

    add_action('wpcf7_init', array(new OpportunitySelector, 'addTag'));
    add_action('wpcf7_init', array(new HiddenUserSelector, 'addTag'));
  }

  /**
   * add_action('init')
   */
  public function init() {
    if (defined('SALESFORCE_LOGIN') && defined('SALESFORCE_PASSWORD') && defined('SALESFORCE_TOKEN')) {
      $cc = new ContactChecker();
    }
  }

  /**
   * add_action('wpcf7_init')
   */
  public function addTag() {
    wpcf7_add_form_tag('school', array($this, 'tagHandler'), array('name-attr' => true));
  }

  /**
   * wpcf7_add_form_tag('bigmarker')
   */
  public function tagHandler($tag) {
    $name = $tag->name;
    if (!$name) {
      $name = 'school';
    }

    return '<input type="text" class="school-autocomplete" /><input type="hidden" name="'.$tag->name.'" class="school-autocomplete-hidden" />';
  }

  /**
   * add_action('wp_enqueue_scripts')
   */
  public function autocompleteEnqueues() {
    wp_enqueue_style(
  		'easy-autocomplete',
  		'https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.min.css',
  		array(),
  		'1.0.7'
  	);
  	wp_enqueue_script(
  		'easy-autocomplete',
  		'https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js',
  		array('jquery'),
  		'1.0.7',
  		true
  	);
  	wp_enqueue_script(
  		'school-autocomplete',
  		plugins_url('school-autocomplete.js', __FILE__),
  		array('easy-autocomplete'),
  		'1.0.0',
  		true
  	);
  	wp_localize_script(
  		'school-autocomplete',
  		'global',
  		array(
  			'search_api' => home_url('wp-json/ol-sf/v1/school-autocomplete')
  		)
  	);
  }
}

new OneloveSalesforce;
