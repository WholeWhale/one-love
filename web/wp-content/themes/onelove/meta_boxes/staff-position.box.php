<?php

/**
 * Outputs the content of the meta box
 */
function staff_position_metabox_markup( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'staff_position_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <input type="text" name="staff-position" style="width: 100%;" value="<?php if ( isset ( $prfx_stored_meta['staff-position'] ) ) echo $prfx_stored_meta['staff-position'][0]; ?>">
    </p>

    <?php
}

/**
 * Adds a meta box to the post editing screen
 */
function create_staff_position_metabox() {

    /**
    * Add metabox to the "page" post type
    */
    $post_types = array('staff_post_type');
    foreach ($post_types as $post_type) {
      add_meta_box(
        'staff_position_meta',
        __( 'Staff Member Position/Title', 'prfx-textdomain' ),
        'staff_position_metabox_markup',
        $post_type
      );
    }
}
  add_action( 'add_meta_boxes', 'create_staff_position_metabox' );

  /**
   * Saves the custom meta input
   */
  function staff_position_metabox_save( $post_id ) {

      // Checks save status
      $is_autosave = wp_is_post_autosave( $post_id );
      $is_revision = wp_is_post_revision( $post_id );
      $is_valid_nonce = ( isset( $_POST[ 'staff_position_nonce' ] ) &&
      wp_verify_nonce( $_POST[ 'staff_position_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

      // Exits script depending on save status
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
          return;
      }

      update_post_meta( $post_id, 'staff-position', sanitize_text_field( $_POST[ 'staff-position' ] ) );

  }
  add_action( 'save_post', 'staff_position_metabox_save' );
