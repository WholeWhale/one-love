<?php
/*

Plugin Name:  Contact Form 7 Salesforce Integration
Description:  Allow submitted values from contact forms to be mapped to SF objects
Version:      1.0
Author:       @cjcodes
Author URI:   https://cj.codes

*/

use Davispeixoto\ForceDotComToolkitForPhp\SforcePartnerClient;

include plugin_dir_path(__FILE__) . '/inc/SettingsPage.php';
include plugin_dir_path(__FILE__) . '/inc/Settings.php';

class CF7Salesforce {
  private $sfDir;
  private $conn;
  private $client;
  private $auth;

  function __construct() {
    add_action('admin_menu', array($this, 'adminSettings'));
    add_action('admin_post', array(new CF7SF_Settings, 'save'));

    add_action('wpcf7_before_send_mail', array($this, 'sync'));
  }

  protected function initializeSalesforce() {
    if (is_null($this->conn)) {
      $this->sfDir = ABSPATH . '../../vendor/davispeixoto/force-dot-com-toolkit-for-php';
      $this->conn = new SforcePartnerClient();
      $this->conn->SforcePartnerClient();
      $this->client = $this->conn->createConnection($this->sfDir . "/wsdl/partner.wsdl.xml");

      if (defined('SALESFORCE_USE_SANDBOX') && SALESFORCE_USE_SANDBOX == '1') {
        $this->conn->setEndpoint('https://test.salesforce.com/services/Soap/u/27.0');
      }

      $this->auth = $this->conn->login(SALESFORCE_LOGIN, SALESFORCE_PASSWORD . SALESFORCE_TOKEN);
    }
  }

  public function adminSettings() {
    add_options_page(
      'CF7 - Salesforce Mappings',
      'CF7-Salesforce Mappings',
      'manage_options',
      'cf7-salesforce',
      array(new CF7SF_SettingsPage(), 'render')
    );
  }

  public function sync($cf7) {
    if (!defined('SALESFORCE_LOGIN') || !defined('SALESFORCE_PASSWORD') || !defined('SALESFORCE_TOKEN')) {
      return;
    }

    $options = CF7SF_Settings::getOption($cf7->id);
    $submission = WPCF7_Submission::get_instance();
    $data = $submission->get_posted_data();

    // If we don't have any SF options, abort
    if (!$options) {
      return;
    }

    $objects = [];
    foreach ($options as $field_name => $fields) {
      list($object, $field) = explode('.', $fields);

      if (!isset($objects[$object])) {
        $objects[$object] = [];
      }

      $objects[$object][$field] = $data[$field_name];
    }

    $this->upsertObjects($objects);
  }

  protected function upsertObjects($object_array) {
    $this->initializeSalesforce();

    foreach ($object_array as $type => $fields) {
      if (!$type) continue;

      $object = new stdClass;
      $object->type = $type;

      foreach ($fields as $field_name => $value) {
        if (!$field_name) continue;
        if (is_array($value) && count($value) == 1) {
          $value = $value[0];
        }

        $object->fields[$field_name] = $value;
      }

      $this->conn->upsert('email', [$object], $type);
    }
  }
}

new CF7Salesforce;
