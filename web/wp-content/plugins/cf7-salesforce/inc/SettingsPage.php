<?php

class CF7SF_SettingsPage {
  public function render() {
    $q = new WP_Query([
      'post_type' => 'wpcf7_contact_form'
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
          $saved = explode('.', $saved_settings[$field->name]);
          $names[] = [
            'name' => $field->name,
            'object' => $saved[0],
            'field' => $saved[1],
          ];
        }
      }

      $form_array['fields'] = $names;
      $forms[] = $form_array;
    }

    include_once 'views/settings.html.php';
  }
}
