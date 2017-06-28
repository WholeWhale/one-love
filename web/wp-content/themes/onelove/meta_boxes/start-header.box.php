<?php
/**
 * Outputs the content of the meta box
 */
function campaign_card_metabox_markup( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'campaign_card_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="campaign-button-cta" class="prfx-row-title">
          <?php _e( 'Button Text:', 'prfx-textdomain' )?>
        </label>
        <br>
        <input type="text" name="campaign-button-cta" maxlength="50" style="width: 100%;" value="<?php if ( isset ( $prfx_stored_meta['campaign-button-cta'] ) ) echo $prfx_stored_meta['campaign-button-cta'][0]; ?>">
    </p>
    <p>
        <label for="campaign-popup" class="prfx-row-title">
          <?php _e( 'Button Popup Content:', 'prfx-textdomain' )?>
        </label>
        <br>
        <textarea name="campaign-popup" rows="12" cols="60" style="width: 100%;"><?php if ( isset ( $prfx_stored_meta['campaign-popup'] ) ) echo $prfx_stored_meta['campaign-popup'][0]; ?></textarea>
    </p>
    <p>
        <label for="campaign-description" class="prfx-row-title">
          <?php _e( 'Description :', 'prfx-textdomain' )?>
        </label>
        <br>
        <textarea id="campaign-description" name="campaign-description" style="width: 100%;" maxlength="150" rows="3" cols="60"><?php if ( isset ( $prfx_stored_meta['campaign-description'] ) ) echo $prfx_stored_meta['campaign-description'][0]; ?></textarea>
        <p id="count"></p>
        <script type="text/javascript">
          var maxchar = 150;
          var i = document.getElementById("campaign-description");
          var c = document.getElementById("count");
          if (i.innerHTML.length) {
            c.innerHTML = 'Characters Left: ' + (maxchar - i.innerHTML.length);
          }
          else {
            c.innerHTML = 'Characters Left: ' +  maxchar;
          }

          i.addEventListener("keydown",count);
          i.addEventListener("input", count);

          function count(e){
            var len =  i.value.length;
            if (len <= maxchar){
               var newValue = len;
               c.innerHTML = 'Characters Left: ' + (maxchar - newValue);
            }
          }
        </script>
    </p>
    <?php
}

/**
 * Adds a meta box to the post editing screen
 */
function create_campaign_card_metabox() {

    /**
    * Add metabox to the "page" post type
    */
    $post_types = array('start_post_type');
    foreach ($post_types as $post_type) {
      add_meta_box(
        'campaign_card_meta',
        __( 'Header: Campaign Card', 'prfx-textdomain' ),
        'campaign_card_metabox_markup',
        $post_type,
        'after_title',
        'high'
      );
    }
}
  add_action( 'add_meta_boxes', 'create_campaign_card_metabox' );



  /**
   * Saves the custom meta input
   */
  function campaign_card_metabox_save( $post_id ) {

      // Checks save status
      $is_autosave = wp_is_post_autosave( $post_id );
      $is_revision = wp_is_post_revision( $post_id );
      $is_valid_nonce = ( isset( $_POST[ 'campaign_card_nonce' ] ) &&
      wp_verify_nonce( $_POST[ 'campaign_card_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

      // Exits script depending on save status
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
          return;
      }

      $fields = array( 'campaign-popup', 'campaign-description', 'campaign-button-cta' );
      foreach ($fields as $field_name) {
        // Checks for input and sanitizes/saves if needed
        if( isset( $_POST[ $field_name ] ) ) {
            update_post_meta( $post_id, $field_name, wp_kses_post( $_POST[ $field_name ] ) );
        }
      }

  }
  add_action( 'save_post', 'campaign_card_metabox_save' );
