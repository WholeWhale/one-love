<?php

/**
 * Outputs the content of the meta box
 */
function homepage_buttons_metabox_markup( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'homepage_buttons_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
      <section>
        <label for="button-1-text">Text for button #1</label>
        <input id="button-1-text" type="text" name="button-1-text" style="width: 100%;" maxlength="150" value="<?php if ( isset ( $prfx_stored_meta['button-1-text'] ) ) echo $prfx_stored_meta['button-1-text'][0]; ?>">
        <label for="button-1-link">URL for button #1</label>
        <input id="button-1-link" type="text" name="button-1-link" style="width: 100%;" maxlength="150" value="<?php if ( isset ( $prfx_stored_meta['button-1-link'] ) ) echo $prfx_stored_meta['button-1-link'][0]; ?>">
      </section>
      <section>
        <label for="button-2-text">Text for button #2</label>
        <input id="button-2-text" type="text" name="button-2-text" style="width: 100%;" maxlength="150" value="<?php if ( isset ( $prfx_stored_meta['button-2-text'] ) ) echo $prfx_stored_meta['button-2-text'][0]; ?>">
        <label for="button-2-link">URL for button #2</label>
        <input id="button-2-link" type="text" name="button-2-link" style="width: 100%;" maxlength="150" value="<?php if ( isset ( $prfx_stored_meta['button-2-link'] ) ) echo $prfx_stored_meta['button-2-link'][0]; ?>">
      </section>
    </p>

    <?php
}



/**
 * Adds a meta box to the post editing screen
 */
function create_homepage_buttons_metabox() {

    /**
    * Add metabox to the "page" post type
    */
    $post_types = array('page');
    foreach ($post_types as $post_type) {
      add_meta_box(
        'homepage_buttons_meta',
        __( 'Home Page Buttons', 'prfx-textdomain' ),
        'homepage_buttons_metabox_markup',
        $post_type,
        'after_title',
        'high'
      );
    }
}
  add_action( 'add_meta_boxes', 'create_homepage_buttons_metabox' );

  /**
   * Saves the custom meta input
   */
  function homepage_buttons_metabox_save( $post_id ) {

      // Checks save status
      $is_autosave = wp_is_post_autosave( $post_id );
      $is_revision = wp_is_post_revision( $post_id );
      $is_valid_nonce = ( isset( $_POST[ 'homepage_buttons_nonce' ] ) &&
      wp_verify_nonce( $_POST[ 'homepage_buttons_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

      // Exits script depending on save status
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
          return;
      }
      $fields = array( 'button-1-text', 'button-1-link', 'button-2-text', 'button-2-link' );
      foreach ($fields as $field_name) {
        // Checks for input and sanitizes/saves if needed
        if( isset( $_POST[ $field_name ] ) ) {
            update_post_meta( $post_id, $field_name, wp_kses_post( $_POST[ $field_name ] ) );
        }
      }
  }
  add_action( 'save_post', 'homepage_buttons_metabox_save' );
