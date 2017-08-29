<?php

class CF7SF_SettingsPage {
  public function render() {
    $q = new WP_Query([
      'post_type' => 'wpcf7_contact_form',
      'posts_per_page' => -1,
    ]);

    $forms = [];

    while ($q->have_posts()) {
      $q->the_post();

      $saved_settings = CF7SF_Settings::getOption($q->post->ID);

      $form_array = [
        'name' => $q->post->post_title,
        'id' => $q->post->ID,
      ];

      $form = WPCF7_ContactForm::get_instance($q->post);
      $fields = wpcf7_scan_form_tags($form);

      $names = [];
      foreach ($fields as $field) {
        if ($field->name) {
          $saved = $saved_settings[$field->name];
          $names[] = [
            'name' => $field->name,
            'object' => $saved['object'],
            'field' => $saved['field'],
            'upsert-key' => $saved['upsert-key'],
          ];
        }
      }

      $form_array['fields'] = $names;
      $forms[] = $form_array;
    }

    include_once 'views/settings.html.php';
  }
}
