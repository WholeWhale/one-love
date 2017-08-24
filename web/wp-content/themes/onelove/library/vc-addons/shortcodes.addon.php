<?php

// sample

// add_filter( 'vc_grid_item_shortcodes', 'my_module_add_grid_shortcodes' );
// function my_module_add_grid_shortcodes( $shortcodes ) {
//    $shortcodes['vc_say_hello'] = array(
//      'name' => __( 'Say Hello', 'my-text-domain' ),
//      'base' => 'vc_say_hello',
//      'category' => __( 'Content', 'my-text-domain' ),
//      'description' => __( 'Just outputs Hello World', 'my-text-domain' ),
//      'post_type' => Vc_Grid_Item_Editor::postType(),
//   );
//    return $shortcodes;
// }

// add_shortcode( 'vc_say_hello', 'vc_say_hello_render' );
// function vc_say_hello_render() {
//    return '<h2>Hello, World!</h2>';
// }



add_filter( 'vc_grid_item_shortcodes', 'categories_enhanced_add_grid_shortcode' );
function categories_enhanced_add_grid_shortcode( $shortcodes ) {
   $shortcodes['vc_categories_enhanced'] = array(
      'name'        => __( 'Post Categories: Enhanced', 'my-text-domain' ),
      'base'        => 'vc_categories_enhanced',
      'icon'        => 'vc_icon-vc-gitem-post-categories',
      'category'    => __( 'Post', 'my-text-domain' ),
      'description' => __( 'Categories of current post with extra features', 'my-text-domain' ),
      'params'      => array(
        array(
          'type'        => 'checkbox',
          'heading'     => 'Add Link',
          'param_name'  => 'link',
          'value'       => '',
          'description' => 'Add link to category?'
        ),
        array(
          'type'        => 'dropdown',
          'heading'     => 'Style',
          'param_name'  => 'category_style',
          'value'       => array(
            'none'                => '',
            'Comma'               => ',',
            'Rounded'             => 'filled vc_grid-filter-filled-round-all',
            'Less Rounded'        => 'filled vc_grid-filter-filled-rounded-all',
            'Border'              => 'bordered',
            'Rounded Border'      => 'bordered-rounded vc_grid-filter-filled-round-all',
            'Less Rounded Border' => 'bordered-rounded-less vc_grid-filter-filled-rounded-all',
          ),
          'description' => 'Select category display style.'
        ),
        array(
          'type'       => 'dropdown',
          'heading'    => 'Color',
          'param_name' => 'category_color',
          'value'      => array(
            'Blue'        => 'blue',
            'Turquoise'   => 'turquoise',
            'Pink'        => 'pink',
            'Violet'      => 'violet',
            'Peacoc'      => 'peacoc',
            'Chino'       => 'chino',
            'Mulled Wine' => 'mulled_wine',
            'Vista Blue'  => 'vista_blue',
            'Black'       => 'black',
            'Grey'        => 'grey',
            'Orange'      => 'orange',
            'Sky'         => 'sky',
            'Green'       => 'green',
            'Juicy pink'  => 'juicy_pink',
            'Sandy brown' => 'sandy_brown',
            'Purple'      => 'purple',
            'White'       => 'white',
            'Coral'       => 'coral',
          ),
          'std' => 'coral',
          'param_holder_class' => 'vc_colored-dropdown',
        ),
        array(
  				'type'        => 'dropdown',
  				'heading'     => __( 'Category size', 'js_composer' ),
  				'param_name'  => 'category_size',
  				'value'       => getVcShared( 'sizes' ),
  				'std'         => 'md',
  				'description' => __( 'Select category size.', 'js_composer' ),
  			),
  			array(
  				'type'        => 'textfield',
  				'heading'     => __( 'Extra class name', 'js_composer' ),
  				'param_name'  => 'el_class',
  				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
  			),
  			array(
  				'type'       => 'css_editor',
  				'heading'    => __( 'CSS box', 'js_composer' ),
  				'param_name' => 'css',
  				'group'      => __( 'Design Options', 'js_composer' ),
  			),
      ),
      'post_type' => Vc_Grid_Item_Editor::postType(),
   );

   return $shortcodes;
}
// output function
add_shortcode( 'vc_categories_enhanced', 'vc_categories_enhanced_render' );
function vc_categories_enhanced_render($atts) {
   return '{{ categories_enhanced:'.http_build_query( (array) $atts ).' }}';
}

add_filter( 'vc_gitem_template_attribute_categories_enhanced', 'vc_gitem_template_attribute_categories_enhanced', 10, 2 );
function vc_gitem_template_attribute_categories_enhanced( $value, $data ) {
   /**
    * @var Wp_Post $post
    * @var string $data
    */
    extract( array_merge( array(
   		'post' => null,
   		'data' => '',
   	), $data ) );
   	$atts_extended = array();
   	parse_str( $data, $atts_extended );

    $atts = $atts_extended['atts'];

    VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Gitem_Post_Categories_Enhanced' );

    $post = get_post( $post->ID );
    $post_type = $post->post_type;
    $taxonomies = get_object_taxonomies( $post_type, 'objects' );

    $separator = '';
    $css_class = array( 'vc_gitem-post-data' );
    $css_class[] = vc_shortcode_custom_css_class( $atts['css'] );
    $css_class[] = $atts['el_class'];
    $css_class[] = 'vc_gitem-post-data-source-post_categories';
    $style = str_replace( ',', 'comma', $atts['category_style'] );
    $output = '<div class="' . esc_attr( implode( ' ', array_filter( $css_class ) ) ) . ' vc_clearfix vc_grid-filter-' . esc_attr( $style ) . ' vc_grid-filter-size-' . esc_attr( $atts['category_size'] ) . ' vc_grid-filter-center vc_grid-filter-color-' . esc_attr( $atts['category_color'] ) . '">';
    $data = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
      // Get the terms related to post.
      $categories = get_the_terms( $post->ID, $taxonomy_slug );
      if ( ! empty( $categories ) ) {
      	foreach ( $categories as  $i => $category ) {

          if ( $i == 0 ) {
            $category_link = '';
        		if ( ! empty( $atts['link'] ) ) {
        			$category_link = 'href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'js_composer' ), $category->name ) ) . '"';
        		}

        		$wrapper = '<div class="vc_gitem-post-category-name">';
        		$content = esc_html( $category->name );
        		if ( ! empty( $category_link ) ) {
        			$content = '<h5 class="vc_gitem-post-category-name"><a ' . $category_link . ' class="vc_gitem-link">' . $content . '</a>' . '</h5>';
        		} else {
        			$content = '<h5 class="vc_gitem-post-category-name">' . $content . '</h5>';
        		}
        		$wrapper_end = '</div>';
        		$data[] = $wrapper . $content . $wrapper_end;
          }



      	}
      }
    }

    if ( empty( $atts['category_style'] ) || ' ' === $atts['category_style'] || ', ' === $atts['category_style'] ) {
    	$separator = $atts['category_style'];
    }
    $output .= implode( $separator, $data );
    $output .= '</div>';

    return $output;
}


add_action( 'vc_before_init', 'card_component' );

function card_component() {
  vc_map( array(
     "name"     => __("Action Card"),
     "base"     => "action_card",
     "category" => __('Content'),
     "weight"   => 100,
     "params"   => array(
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Card Icon", "my-text-domain" ),
            "param_name"  => "icon",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The icon that will display at the upper-left side of the card.", "my-text-domain" )
         ),
       array(
          "type"       => "dropdown",
          "holder"     => "div",
          "class"      => "",
          "heading"    => __( "Card Icon Font", "my-text-domain" ),
          "param_name" => "font_family",
          "value"      => array(
            "Material Font Awesome" => "Material-Design-Iconic-Font",
            "Lato"                  => "Lato,sans-serif",
            "Font Awesome"          => "FontAwesome",
          ),
          "description" => __( "The font to use for the card icon", "my-text-domain" )
       ),
       array(
          "type"       => "dropdown",
          "holder"     => "div",
          "class"      => "",
          "heading"    => __( "Card Color", "my-text-domain" ),
          "param_name" => "color",
          "value"      => array(
            "Green" => "#55c6b6",
            "Red"   => "#ff5e5b",
            "Navy"  => "#1a596a"
          ),
          "description" => __( "The border color for the card.", "my-text-domain" )
       ),
        array(
           "type" => "textarea_html",
           "holder" => "div",
           "class" => "",
           "heading" => __("Text"),
           "param_name" => "content",
           "value" => __("Enter the content that will display on the card here."),
           "description" => __("Select the face of the card this will represent if flip animation is used.")

        ),
        array(
          'type'        => 'dropdown',
          'heading'     => 'Card Flip Face',
          'param_name'  => 'card_flip_face',
          'value'       => array(
            'Front' => ' front',
            'Back'  => ' back',
            'None'  => 'false',
          ),
          'std'         => 'false',
          'description' => 'Select category display style.'
        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __( "Extra Classes", "my-text-domain" ),
             "param_name" => "extra_classes",
             "description" => __("Style particular content element differently - add a class name and refer to it in custom CSS.")
          ),
        array(
             "type" => "checkbox",
             "holder" => "div",
             "class" => "",
             "heading" => __( "Use Pardot Form?", "my-text-domain" ),
             "param_name" => "use_pardot_form",
             "description" => __("Whether or not to display a pardot form on the right side of the content")
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __( "Pardot Form ID", "my-text-domain" ),
             "param_name" => "pardot_form_id",
             "description" => __("The form id that fills in the xxxxx portion of the shortcode [pardot-form id='xxxxx' height='290']"),
             "dependency" => array(
               "element" => "use_pardot_form",
               "value"   => "true"
             ),
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __( "Pardot Form Height", "my-text-domain" ),
             "param_name" => "pardot_form_height",
             "description" => __("The form height that fills in the xxxxx portion of the shortcode [pardot-form id='1234' height='xxxxx']"),
             "dependency" => array(
               "element" => "use_pardot_form",
               "value"   => "true"
             ),
          ),
     )
  ) );
}


add_shortcode('action_card','action_card');

function random($max = 500){
  $random = rand(1, $max);
  $bgClass = "card-".$random;
  return $bgClass;
}

function action_card( $atts, $content = null ) {

  extract( shortcode_atts( array(
      'icon'               => '',
      'color'              => '#55c6b6',
      'font_family'        => 'Material-Design-Iconic-Font',
      'extra_classes'      => '',
      'card_flip_face'     => '',
      'use_pardot_form'    => 'false',
      'pardot_form_id'     => '',
      'pardot_form_height' => '290',
   ), $atts ) );


  if ($font_family == 'FontAwesome' || $font_family == 'Material-Design-Iconic-Font' & $icon !== '' ) {
    $icon =  '\f'.$icon;
  }

  if ($card_flip_face == 'false') {
    $card_flip_face = '';
  }

  $unique_iden = random();
  ob_start();

  echo "
  <style media='screen'>
    #".$unique_iden.".action-card { border-top-color: ".$color."; }
    #".$unique_iden.".action-card:before { content: '".$icon ."'; background: ".$color."; font-family: ".$font_family.";}
  </style>
  ";

    if ( $use_pardot_form == 'true' ) {
      echo "<div id='" . $unique_iden ."' class='action-card action-card-display-pardot-parent vc_card_spacing ".$extra_classes.$card_flip_face."'".$extra_attribs." data-equalizer-watch='card'>";
      echo do_shortcode(
        '<section class="action-card-display-pardot">'.$content.'</section><section class="green action-card-display-pardot">[pardot-form id="'.$pardot_form_id.'" height="'.$pardot_form_height.'"]</section>'
      );
    }
    else {
      echo "<div id='" . $unique_iden ."' class='action-card vc_card_spacing ".$extra_classes.$card_flip_face."'".$extra_attribs." data-equalizer-watch='card'>";
      echo do_shortcode(
        $content
      );
    }
  echo  "
  </div>";

  return ob_get_clean();

}



add_action( 'vc_before_init', 'membership_card_component' );

function membership_card_component() {
  vc_map( array(
     "name"     => __("Membership Card"),
     "base"     => "membership_card_output",
     "category" => __('Content'),
     "weight"   => 99,
     "params"   => array(
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Headline", "my-text-domain" ),
            "param_name"  => "membership_headline",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The headline text that will display on the card.", "my-text-domain" )
         ),
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Pardot Form ID", "my-text-domain" ),
            "param_name"  => "membership_pardot_id",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The form id that fills in the xxxxx portion of the shortcode [pardot-form id='xxxxx' height='290']", "my-text-domain" )
         ),
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Pardot Form Height", "my-text-domain" ),
            "param_name"  => "membership_pardot_height",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The form height that fills in the xxxxx portion of the shortcode [pardot-form id='1234' height='xxxxx']", "my-text-domain" )
         ),
      )
    )
  );
}

add_shortcode('membership_card_output','membership_card_output');

function membership_card_output( $atts ) {
  extract( shortcode_atts( array(
      'membership_headline'           => '',
      'membership_pardot_id'          => '',
      'membership_pardot_height'      => '290',
   ), $atts ) );
   ob_start();?>
   <div class="vc-membership-card green">
     <h2 class="vc-membership-headline"><?php echo $membership_headline; ?></h2>
     <div class="vc-membership-section-container">
       <section class="vc-membership-pardot">
         <?php echo do_shortcode('[pardot-form id="'.$membership_pardot_id.'" height="'.$membership_pardot_height.'"]'); ?>
       </section>
       <section class="vc-membership-dynamic-card">
         <?php echo do_shortcode('[membership_card]',true); ?>
       </section>
     </div>
   </div>
   <?php
   return ob_get_clean();
}


add_action( 'vc_before_init', 'modal_video_component' );

function modal_video_component() {
  vc_map( array(
     "name"     => __("Video Popup"),
     "base"     => "modal_video_output",
     "category" => __('Content'),
     "weight"   => 98,
     "params"   => array(
       array(
            "type"        => "attach_image",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Thumbnail Image", "my-text-domain" ),
            "param_name"  => "modal_video_thumbnail_image",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "Select image from media library. Will display as thumbnail image for popup/modal", "my-text-domain" )
         ),
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Thumbnail Size", "my-text-domain" ),
            "param_name"  => "modal_video_thumbnail_size",
            "value"       => __( "thumbnail", "my-text-domain" ),
            "description" => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', "my-text-domain" )
         ),
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Youtube Video ID", "my-text-domain" ),
            "param_name"  => "modal_video_id_youtube",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The ID for the youtube video that will display when popup/modal opens.", "my-text-domain" )
         ),
       array(
            "type"        => "textfield",
            "holder"      => "div",
            "class"       => "",
            "heading"     => __( "Vimeo Video ID", "my-text-domain" ),
            "param_name"  => "modal_video_id_vimeo",
            "value"       => __( "", "my-text-domain" ),
            "description" => __( "The ID for the vimeo video that will display when popup/modal opens if youtube video ID not specified", "my-text-domain" )
       ),
      )
    )
  );
}

add_shortcode('modal_video_output','modal_video_output');

function modal_video_output($atts) {

  extract( shortcode_atts( array(
      'modal_video_thumbnail_image' => 'false',
      'modal_video_thumbnail_size'  => 'thumbnail',
      'modal_video_id_youtube'      => 'false',
      'modal_video_id_vimeo'        => 'false',
   ), $atts ) );
   $ran = random();
   $video_ran = random();
   if ( ($modal_video_id_youtube === 'false' && $modal_video_id_vimeo === 'false') || $modal_video_thumbnail_image === 'false') {
     return;
   }
   ob_start();?>
   <a>
   <div class="video-modal">
     <img src="<?php echo wp_get_attachment_image_src($modal_video_thumbnail_image,$modal_video_thumbnail_size)[0]; ?>" alt="Video Thumbnail"  data-open="videoModal-<?php echo $ran; ?>" >
     <img class="modal-play-button" src="/wp-content/themes/onelove/assets/images/play-button.svg" alt="Play Button"  data-open="videoModal-<?php echo $ran; ?>" >
     <section id="videoModal-<?php echo $ran; ?>" class="reveal mod-reveal" data-animation-in="fade-in" data-animation-out="fade-out"  data-reveal>
         <div id="video-<?php echo $video_ran; ?>" ></div>
     </section>

     <?php if ( $modal_video_id_vimeo !== 'false' && $modal_video_id_youtube === 'false' ): ?>
       <script src="https://player.vimeo.com/api/player.js"></script>
       <script>


          <?php $randomNum = rand(1, 500); ?>
          var player<?php echo $randomNum; ?> = '';

          $(document).on('open.zf.reveal', '#videoModal-<?php echo $ran; ?>[data-reveal]', function (e) {
            var options = {
                id: <?php echo $modal_video_id_vimeo; ?>,
            };
            player<?php echo $randomNum; ?> = new Vimeo.Player('video-<?php echo $video_ran; ?>', options);
            player<?php echo $randomNum; ?>.play();
          });
          $(document).on('closed.zf.reveal', '#videoModal-<?php echo $ran; ?>[data-reveal]', function () {
              $('#video-<?php echo $video_ran; ?>').replaceWith('<div id="video-<?php echo $video_ran; ?>" ></div>');
          });

      </script>
     <?php endif; ?>
     <?php if ( $modal_video_id_youtube !== 'false' ): ?>
       <script type="text/javascript">
       <?php $randomNum = rand(1, 500); ?>
       // assumes youtube iframe api script is loaded by VC
       var player<?php echo $randomNum; ?>;

       $(document).on('open.zf.reveal', '#videoModal-<?php echo $ran; ?>[data-reveal]', function (e) {
         console.log(e);
         function onYouTubeIframeAPIReady() {
           player<?php echo $randomNum; ?> = new YT.Player("video-<?php echo $video_ran; ?>", {
             videoId: '<?php echo $modal_video_id_youtube; ?>',
             width: "",
             height: "",
             autoplay: 1,
             events: {
               'onReady': onPlayerReady,
             }
           });
         }
          onYouTubeIframeAPIReady();
          function onPlayerReady() {
            player<?php echo $randomNum; ?>.playVideo();
          }
       });
       $(document).on('closed.zf.reveal', '#videoModal-<?php echo $ran; ?>[data-reveal]', function () {
         player<?php echo $randomNum; ?>.stopVideo().destroy();
       });
       </script>
     <?php endif; ?>
   </div>
   </a>
   <?php
  return ob_get_clean();
}
