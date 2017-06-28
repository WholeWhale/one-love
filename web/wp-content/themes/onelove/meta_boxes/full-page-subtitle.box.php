<?php

/**
 * Outputs the content of the meta box
 */
function subtitle_metabox_markup( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'subtitle_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <input id="full-page-temp-subtitle" type="text" name="subtitle" style="width: 100%;" maxlength="150" value="<?php if ( isset ( $prfx_stored_meta['subtitle'] ) ) echo $prfx_stored_meta['subtitle'][0]; ?>">
        <p id="count"></p>
    </p>



    <script type="text/javascript">
    jQuery(function(){
      var maxchar = 150;
      var i = document.getElementById("full-page-temp-subtitle");
      var c = document.getElementById("count");
      if (i.value) {
        c.innerHTML = 'Characters Left: ' + (maxchar - i.value.length);
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
    });
    </script>
    <?php
}



add_action( 'admin_head-post.php', 'metabox_switcher' );
add_action( 'admin_head-post-new.php', 'metabox_switcher' );

function metabox_switcher( $post ){

        #Locate the ID of your metabox with Developer tools
        $metabox_selector_id = 'subtitle_meta';
        echo '
            <style type="text/css">
                /* Hide your metabox so there is no latency flash of your metabox before being hidden */
                #'.$metabox_selector_id.'{display:none;}
            </style>
            <script type="text/javascript">
                jQuery(document).ready(function($){

                    //You can find this in the value of the Page Template dropdown
                    var templateName = "page-templates/page-full-width.php";

                    //Page template in the publishing options
                    var currentTemplate = $("#page_template");

                    //Identify your metabox
                    var metabox = $("#'.$metabox_selector_id.'");

                    //On DOM ready, check if your page template is selected
                    if(currentTemplate.val() === templateName){
                        metabox.show();
                    }

                    //Bind a change event to make sure we show or hide the metabox based on user selection of a template
                    currentTemplate.change(function(e){
                        if(currentTemplate.val() === templateName){
                            metabox.show();
                        }
                        else{
                            //You should clear out all metabox values here;
                            metabox.hide();
                        }
                    });
                });
            </script>
        ';
}

/**
 * Adds a meta box to the post editing screen
 */
function create_subtitle_metabox() {

    /**
    * Add metabox to the "page" post type
    */
    $post_types = array('page');
    foreach ($post_types as $post_type) {
      add_meta_box(
        'subtitle_meta',
        __( 'Subtitle', 'prfx-textdomain' ),
        'subtitle_metabox_markup',
        $post_type,
        'after_title',
        'high'
      );
    }
}
  add_action( 'add_meta_boxes', 'create_subtitle_metabox' );

  /**
   * Saves the custom meta input
   */
  function subtitle_metabox_save( $post_id ) {

      // Checks save status
      $is_autosave = wp_is_post_autosave( $post_id );
      $is_revision = wp_is_post_revision( $post_id );
      $is_valid_nonce = ( isset( $_POST[ 'subtitle_nonce' ] ) &&
      wp_verify_nonce( $_POST[ 'subtitle_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

      // Exits script depending on save status
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
          return;
      }

      update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST[ 'subtitle' ] ) );

  }
  add_action( 'save_post', 'subtitle_metabox_save' );
