<?php

function enqueue_assets() {
  wp_enqueue_style( 'main-fonts','https://fonts.googleapis.com/css?family=Lato:400,400i|Overpass',false );
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
  wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/assets/javascript/onelove.js', array('jquery'), '2.9.0', true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_assets' );

/**
 * Allow loading of svg images within media library
 */
function custom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['svg'] = 'mime/type';
    return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

function register_post_types() {
  foreach (glob(get_stylesheet_directory() . '/post_types/*.type.php') as $type) {
    $typeName = basename($type, '.type.php') . '_post_type';
    $definition = include $type;
    register_post_type($typeName, $definition);
  }
}
add_action('init', 'register_post_types');

function update_admin_menu_pos() {
    global $menu;
    $post_types = array( 5 => 'Posts', 25 => 'Comments' );
    $new_position = 50;
    foreach ($post_types as $key => $value) {
      $copy = $menu[$key];
      unset( $menu[$key] );
      $menu[$new_position] = $copy;
      $new_position++;
    }
}
add_action( 'admin_menu', 'update_admin_menu_pos');

function remove_bloat_assets() {
  wp_dequeue_style('main-stylesheet');
  wp_dequeue_script('foundation');
}
add_action('wp_enqueue_scripts', 'remove_bloat_assets', 100);

/**
 * having a version number attached to files is a cache-buster. No need for a
 * cache-buster for development when FF and Chrome already have cache-busting
 * capabilities.
 */
function remove_assets_version_num( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
// Remove WP Version From Styles
add_filter( 'style_loader_src', 'remove_assets_version_num', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'remove_assets_version_num', 9999 );

function register_meta_boxes() {
  foreach (glob(get_stylesheet_directory() . '/meta_boxes/*.box.php') as $type) {
    include $type;
  }
}
add_action('after_setup_theme', 'register_meta_boxes');

function unique_categories() {

  $args = array(
       'public'   => true,
       '_builtin' => false,
    );


    $post_types = get_post_types( $args, 'names', 'and' );

    foreach ( $post_types  as $post_type ) {

      // create a new taxonomy
      $labels = array(
    		'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
    		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
    		'search_items'      => __( 'Search Categories', 'textdomain' ),
    		'all_items'         => __( 'All Categories', 'textdomain' ),
    		'parent_item'       => __( 'Parent Category', 'textdomain' ),
    		'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
    		'edit_item'         => __( 'Edit Categories', 'textdomain' ),
    		'update_item'       => __( 'Update Category', 'textdomain' ),
    		'add_new_item'      => __( 'Add New Category', 'textdomain' ),
    		'new_item_name'     => __( 'New Category', 'textdomain' ),
    		'menu_name'         => __( 'Categories', 'textdomain' ),
    	);
      $post_type_base_name = preg_replace( '/_post_type/','',$post_type );
      register_taxonomy(
        $post_type_base_name.'_category',
        $post_type,
        array(
          'labels'             => $labels,
          'publicly_queryable' => true,
          'rewrite'            => array( 'slug' => $post_type_base_name .'-category' ),
          'hierarchical'      =>  true,
        )
      );
    }

}
add_action( 'init', 'unique_categories' );


foreach (glob('{'. get_stylesheet_directory() . '/library/*.php,'.get_stylesheet_directory() . '/library/vc-addons/*.addon.php}',GLOB_BRACE) as $file) {
  include $file;
}

function my_module_add_grid_shortcodes( $shortcodes ) {
   $shortcodes['vc_say_hello'] = array(
     'name' => __( 'Say Hello', 'my-text-domain' ),
     'base' => 'vc_say_hello',
     'category' => __( 'Content', 'my-text-domain' ),
     'description' => __( 'Just outputs Hello World', 'my-text-domain' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
  );
   return $shortcodes;
}
add_filter( 'vc_grid_item_shortcodes', 'my_module_add_grid_shortcodes' );


function vc_say_hello_render() {
   return '<h2>Hello, World!</h2>';
}
add_shortcode( 'vc_say_hello', 'vc_say_hello_render' );


function social_media_icons( $atts ) {

  extract(shortcode_atts(array(
      'facebook_url'  => 'https://www.facebook.com/JoinOneLove',
      'youtube_url'   => 'https://www.youtube.com/user/JoinOneLove',
      'twitter_url'   => 'https://twitter.com/Join1Love',
      'instagram_url' => 'https://www.instagram.com/join1love/',
      'alignment'     => 'left',
   ), $atts));

  ob_start(); ?>

  <div class="row social-media-icons-container align-<?php echo $alignment; ?>">
    <a class="column facebook-anchor social-media-icon" href="<?php echo $facebook_url; ?>" target="_blank">
      <i class="fa fa-facebook" aria-hidden="true"></i>
    </a>
    <a class="column youtube-anchor social-media-icon" href="<?php echo $youtube_url; ?>" target="_blank">
      <i class="fa fa-youtube" aria-hidden="true"></i>
    </a>
    <a class="column youtube-anchor social-media-icon" href="<?php echo $twitter_url; ?>" target="_blank">
      <i class="fa fa-twitter" aria-hidden="true"></i>
    </a>
    <a class="column youtube-anchor social-media-icon" href="<?php echo $instagram_url; ?>" target="_blank">
      <i class="fa fa-instagram" aria-hidden="true"></i>
    </a>
  </div>


  <?php
  return ob_get_clean();
}
add_shortcode('social_media','social_media_icons');

function move_advance_pos_after_title() {
  global $post, $wp_meta_boxes;

  do_meta_boxes( get_current_screen(), 'after_title',$post );
  unset($wp_meta_boxes[get_post_type($post)]['after_title']);
}
add_action('edit_form_after_title','move_advance_pos_after_title');

function metabox_switcher( $post ){

        #Locate the ID of your metabox with Developer tools
        $metabox_selector_id = 'subtitle_meta';
        $conversation_metabox_id = 'campaign_card_meta';
        echo '
            <style type="text/css">
                /* Hide your metabox so there is no latency flash of your metabox before being hidden */
                #'.$metabox_selector_id.',#'.$conversation_metabox_id.'{display:none;}
            </style>
            <script type="text/javascript">
                jQuery(document).ready(function($){

                    //You can find this in the value of the Page Template dropdown
                    var templateName = "page-templates/page-full-width.php";
                    var convoTemplateName = "single-start_post_type.php";

                    //Page template in the publishing options
                    var currentTemplate = $("#page_template");

                    //Identify your metabox
                    var metabox = $("#'.$metabox_selector_id.'");
                    var convometabox = $("#'.$conversation_metabox_id.'");

                    //On DOM ready, check if your page template is selected
                    if(currentTemplate.val() === templateName){
                        metabox.show();
                    }
                    if(currentTemplate.val() === convoTemplateName){
                        convometabox.show();
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
                        if(currentTemplate.val() === convoTemplateName){
                            convometabox.show();
                        }
                        else{
                            //You should clear out all metabox values here;
                            convometabox.hide();
                        }
                    });
                });
            </script>
        ';
}
add_action( 'admin_head-post.php', 'metabox_switcher' );
add_action( 'admin_head-post-new.php', 'metabox_switcher' );


function foundationpress_sidebar_widgets() {
	register_sidebar(array(
	  'id' => 'sidebar-widgets',
	  'name' => __( 'Sidebar widgets', 'foundationpress' ),
	  'description' => __( 'Drag widgets to this sidebar container.', 'foundationpress' ),
	  'before_widget' => '<article id="%1$s" class="widget %2$s">',
	  'after_widget' => '</article>',
	  'before_title' => '<h6>',
	  'after_title' => '</h6>',
	));

	register_sidebar(array(
	  'id' => 'footer-widgets',
	  'name' => __( 'Footer widgets', 'foundationpress' ),
	  'description' => __( 'Drag widgets to this footer container', 'foundationpress' ),
	  'before_widget' => '<article id="%1$s" class="large-12 footer-widget-container columns widget %2$s">',
	  'after_widget' => '</article>',
	  'before_title' => '<h6>',
	  'after_title' => '</h6>',
	));
}
add_action( 'widgets_init', 'foundationpress_sidebar_widgets' );


function post_footer_widgets() {
  $atts = array(
    'alignment' => 'center',
  );
  echo social_media_icons($atts);
}
add_action('foundationpress_after_footer','post_footer_widgets');



function my_plugin_wp_setup_nav_menu_item( $menu_item ) {
  if ( isset( $menu_item->post_type ) ) {
      if ( 'nav_menu_item' == $menu_item->post_type ) {
          $menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
      }
  }
  return $menu_item;
}
remove_filter( 'nav_menu_description', 'strip_tags' );
add_filter( 'wp_setup_nav_menu_item', 'my_plugin_wp_setup_nav_menu_item' );

function prefix_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) & $item->description !== ' ' ) {
        $item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a>' . '<ul class="sub-menu"><li class="menu-item menu-item-type-custom menu-item-object-custom">' . do_shortcode($item->description) . '</li></ul>', $item_output );
    }

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );
