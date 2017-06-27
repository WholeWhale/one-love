<?php
/*
Plugin Name:  Wordpress Keystore
Description:  Save API keys and passwords to the database encrypted and accessible as environmental variables.
Version:      1.0
Author:       @cjcodes
Author URI:   https://cj.codes
*/

include_once 'WPKeystore_SettingsPage.php';
include_once 'WPKeystore_Settings.php';

class WPKeystore {
  public function __construct() {
    add_action('admin_menu', array($this, 'settings'));
    add_action('admin_post', array(new WPKeystore_SettingsPage, 'save'));
    add_action('init', array(new WPKeystore_Settings, 'toGlobals'), -1);
  }

  public function settings() {
    add_options_page(
      'API Keys',
      'API Keys',
      'manage_options',
      'api-keys',
      array(new WPKeystore_SettingsPage(), 'render')
    );
  }
}

new WPKeystore;
