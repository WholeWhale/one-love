<?php

class CF7SF_Settings {
  const NONCE = 'cf7sf-save';
  const NONCE_MSG = 'cf7sf-nonce';
  const PREFIX = 'cf7sf';

  public function save() {
    if (!($this->has_valid_nonce() && current_user_can('manage_options'))) {
      // TODO
    }

    foreach ($_POST['forms'] as $id => $values) {
      $opts = [];

      foreach ($values as $formkey => $value) {
        $opts[$formkey] = $value['object'] . '.' . $value['field'];
      }

      update_option(self::PREFIX . '-form-' . $id, $opts);
    }

    $this->redirect();
  }

  public static function getOption($formId) {
    return get_option(self::PREFIX . '-form-' . $formId);
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

  private function has_valid_nonce() {
    return wp_verify_nonce($_POST[self::NONCE_MSG], self::NONCE);
  }
}
