<?php

/**
 * Outputs the content of the meta box
 */
function staff_lastname_metabox_markup( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'staff_lastname_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <p>Used for sorting on staff grid. This field is automatically populated when post is published but can be overwritten if last name obtained is incorrect.</p>
        <input type="text" name="lastname" style="width: 100%;" value="<?php if ( isset ( $prfx_stored_meta['lastname'] ) ) echo $prfx_stored_meta['lastname'][0]; ?>">
    </p>

    <?php
}

/**
 * Adds a meta box to the post editing screen
 */
function create_staff_lastname_metabox() {

  /**
  * Add metabox to the "page" post type
  */
  $post_types = array('staff_post_type');
  foreach ($post_types as $post_type) {
    add_meta_box(
      'staff_lastname_meta',
      __( 'Staff Member Last Name', 'prfx-textdomain' ),
      'staff_lastname_metabox_markup',
      $post_type,
      'after_title',
      'high'
    );
  }
}
add_action( 'add_meta_boxes', 'create_staff_lastname_metabox' );

/**
 * Saves the custom meta input
 */
function staff_lastname_metabox_save( $post_id ) {

   // Checks save status
   $is_autosave = wp_is_post_autosave( $post_id );
   $is_revision = wp_is_post_revision( $post_id );
   $is_staff_post_type = get_post_type( $post_id );
   $field_name = 'lastname';
   $is_valid_nonce = ( isset( $_POST[ 'staff_lastname_nonce' ] ) &&
   wp_verify_nonce( $_POST[ 'staff_lastname_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

   // Exits script depending on save status
   if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
       return;
   }

   $post_status = get_post_status( $post_id );
   if ( $post_status !== 'auto-draft' ) {
     $title = get_the_title( $post_id );
     $last_name  = substr($title, strripos($title, " "));
     // Checks for input and sanitizes/saves if needed
     $current_meta_value = sanitize_text_field( $_POST[ 'lastname' ] );
     if ( $last_name !== $current_meta_value & !empty($current_meta_value) ) {
       update_post_meta( $post_id, $field_name, $current_meta_value );
     }
     else {
       update_post_meta( $post_id, $field_name, $last_name );
     }
   }

}
add_action( 'save_post', 'staff_lastname_metabox_save' );
