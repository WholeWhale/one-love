<?php

include_once 'WPKeystore_Settings.php';

class WPKeystore_SettingsPage {
  const NONCE = 'wpkeystore';
  const NONCE_MSG = 'wpkeystore-nonce';

  public function render() {
    $keys = WPKeystore_Settings::asArray();

    include 'views/settings.html.php';
  }

  public function save() {
    if (!($this->has_valid_nonce() && current_user_can('manage_options'))) {
      return;
    }

    $name = $_POST['name'];
    $key = $_POST['key'];

    $keystore = new WPKeystore_Settings;
    $keystore->add($name, $key);

    $this->redirect();
  }

  private function has_valid_nonce() {
    return wp_verify_nonce($_POST[self::NONCE_MSG], self::NONCE);
  }

  private function redirect() {
    if (!isset($_POST['_wp_http_referer'])) {
      $_POST['_wp_http_referer'] = wp_login_url();
    }

    $url = sanitize_text_field(
      wp_unslash($_POST['_wp_http_referer'])
    );

    wp_safe_redirect(urldecode($url));
  }
}
