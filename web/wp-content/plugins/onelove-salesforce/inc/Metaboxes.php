<?php

class Metaboxes {

  const NONCE  = 'ol-sf-nonce';
  const FIELD  = 'ol-sf-field';
  const FILTER = 'ol-sf-filter';
  const KEY    = 'ol-sf-meta';

  public function setup() {
    add_action('add_meta_boxes', array($this, 'create'));
    add_action('save_post', array($this, 'save'), 10, 2);
  }

  public function create() {
    add_meta_box(
      $id       = 'salesforce-email-protected',
      $title    = esc_html__('Salesforce Contact Content Gate', 'onelove-salesforce'),
      $callback = array($this, 'content'),
      $screen   = null,
      $context  = 'side',
      $priority = 'default'
    );
  }

  public function save($post_id, $post) {
    if (!isset($_POST[self::NONCE]) || !wp_verify_nonce($_POST[self::NONCE], basename(__FILE__))) {
      return $post_id;
    }

    $post_type = get_post_type_object($post->post_type);
    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
      return $post_id;
    }

    $val = isset($_POST[self::FIELD]);
    if ($val && isset($_POST[self::FILTER]) && $_POST[self::FILTER] !== '') {
      $val = $_POST[self::FILTER];
    }

    if (!$val) {
      delete_post_meta($post_id, self::KEY);
    } else {
      update_post_meta($post_id, self::KEY, $val);
    }
  }

  public function content($post) {
    $val = get_post_meta($post->ID, self::KEY, true);
    $checked = ($val) ? 'checked="checked"' : '';
    $inputVal = ($val == '1') ? '' : $val;
  ?>

  <?php wp_nonce_field(basename(__FILE__), self::NONCE); ?>

  <p>
    <label for="<?php echo self::FIELD; ?>">
      <input type="checkbox" name="<?php echo self::FIELD; ?>" id="<?php echo self::FIELD; ?>" <?php echo $checked; ?> />
      Limit access to SF contacts only
    </label>
  </p>
  <p>
    <label for="<?php echo self::FILTER; ?>">
      <strong>Restrict by Campaign ID:</strong>
      <input type="text" name="<?php echo self::FILTER; ?>" id="<?php echo self::FILTER; ?>" placeholder="no campaign restriction" value="<?php echo $inputVal; ?>"/>
    </label>
  </p>
  <?php
  }
}
