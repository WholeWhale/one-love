<?php

class Metaboxes {

  const NONCE  = 'ol-sf-nonce';
  const FIELD  = 'ol-sf-field';
  const FILTER = 'ol-sf-filter';
  const STATUS = 'ol-sf-status';
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

    // checkbox is checked?
    $shouldSet = isset($_POST[self::FIELD]);

    if (!$shouldSet) {
      delete_post_meta($post_id, self::KEY);
    } else {
      $val = $_POST[self::FILTER] . '|' . $_POST[self::STATUS];
      update_post_meta($post_id, self::KEY, $val);
    }
  }

  public static function getSettings($postId) {
    $meta = get_post_meta($postId, Metaboxes::KEY, true);

    if (!$meta) {
      return false;
    } else if (strpos($meta, '|') === false) {
      return [
        'campaign' => ($meta != '1') ? $meta : false,
        'status' => false,
      ];
    } else {
      $meta = explode('|', $meta);

      return [
        'campaign' => ($meta[0]) ?: false,
        'status' => ($meta[1]) ?: false,
      ];
    }
  }

  public function content($post) {
    $val = self::getSettings($post->ID);
    $checked = $campaign = $status = '';

    if ($val) {
      $checked = 'checked="checked"';
      $campaign = $val['campaign'] ?: '';
      $status = $val['status'] ?: '';
    }
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
      <input type="text" name="<?php echo self::FILTER; ?>" id="<?php echo self::FILTER; ?>" placeholder="no campaign restriction" value="<?php echo $campaign; ?>"/>
    </label>
  </p>
  <p>
    <label for="<?php echo self::STATUS; ?>">
      <strong>Campaign Status Filter:</strong>
      <input type="text" name="<?php echo self::STATUS; ?>" id="<?php echo self::STATUS; ?>" placeholder="no status restriction" value="<?php echo $status; ?>"/>
    </label>
  </p>
  <?php
  }
}
