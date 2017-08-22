<?php

function enqueue_assets() {
  wp_enqueue_style( 'main-fonts','https://fonts.googleapis.com/css?family=Lato:400,400i|Overpass:200,400,700,900',false );
  wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/stylesheets/onelove.css' );
  wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/assets/javascript/onelove.js', array('jquery'), '2.9.0', true);
  wp_enqueue_script('flip_js','https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js',array('jquery'),'',true);
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

function create_audience_taxonomy() {
  $labels = array(
    'name'              => _x( 'Audience', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Audience', 'taxonomy singular name', 'textdomain' ),
    'search_items'      => __( 'Search Audience', 'textdomain' ),
    'all_items'         => __( 'All Audience', 'textdomain' ),
    'parent_item'       => __( 'Parent Audience', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Audience:', 'textdomain' ),
    'edit_item'         => __( 'Edit Audience', 'textdomain' ),
    'update_item'       => __( 'Update Audience', 'textdomain' ),
    'add_new_item'      => __( 'Add New Audience', 'textdomain' ),
    'new_item_name'     => __( 'New Audience', 'textdomain' ),
    'menu_name'         => __( 'Audience', 'textdomain' ),
  );
  register_taxonomy(
    'audience',
    'learn_post_type',
    array(
      'labels'             => $labels,
      'publicly_queryable' => true,
      'rewrite'            => array( 'slug' => 'audience' ),
      'hierarchical'      =>  true,
    )
  );
}
add_action('init','create_audience_taxonomy');

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
        $metabox_selector_id     = 'subtitle_meta';
        $conversation_metabox_id = 'campaign_card_meta';
        $homepage_metabox        = 'homepage_buttons_meta';
        echo '
            <style type="text/css">
                /* Hide your metabox so there is no latency flash of your metabox before being hidden */
                #'.$metabox_selector_id.',#'.$conversation_metabox_id.',#'.$homepage_metabox.'{display:none;}
            </style>
            <script type="text/javascript">
                jQuery(document).ready(function($){

                    //You can find this in the value of the Page Template dropdown
                    var templateName      = "page-templates/page-full-width.php";
                    var convoTemplateName = "page-templates/page-start.php";
                    var homeTemplateName  = "page-templates/page-home.php";
                    var templateName = "page-templates/page-full-width.php";
                    var convoTemplateName = "single-act_post_type.php";

                    //Page template in the publishing options
                    var currentTemplate = $("#page_template");

                    if( $(".post-type-act_post_type").length ) {
                      $("#'.$conversation_metabox_id.'").show();
                    }

                    //Identify your metabox
                    var metabox         = $("#'.$metabox_selector_id.'");
                    var convometabox    = $("#'.$conversation_metabox_id.'");
                    var homepagemetabox = $("#'.$homepage_metabox.'");

                    //On DOM ready, check if your page template is selected
                    if(currentTemplate.val() === templateName || currentTemplate.val() === homeTemplateName){
                        metabox.show();
                    }
                    if(currentTemplate.val() === convoTemplateName){
                        convometabox.show();
                    }
                    if(currentTemplate.val() === homeTemplateName){
                        homepagemetabox.show();
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
                        if(currentTemplate.val() === homeTemplateName){
                            homepagemetabox.show();
                        }
                        else{
                            //You should clear out all metabox values here;
                            homepagemetabox.hide();
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
  register_sidebar(array(
	  'id' => 'footer-widgets-bottom-section',
	  'name' => __( 'Footer widgets: Bottom Section', 'foundationpress' ),
	  'description' => __( 'Drag widgets to this footer container in order to display it within the darker portion of the footer', 'foundationpress' ),
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
add_action('foundationpress_footer_bottom_section_after','post_footer_widgets');



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



function inject_gtm_body_script() {
  if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) {
     gtm4wp_the_gtm_tag();
  }
}
add_action('foundationpress_after_body','inject_gtm_body_script');


function check_metadata() {
  global $post;
  $myvals = get_post_meta($post->ID);

  foreach($myvals as $key=>$val)
  {
      echo $key . ' : ' . $val[0] . '<br/>';
  }
}
add_shortcode('check_metadata','check_metadata');

function add_additional_image_sizes() {
  add_image_size( 'featured-alt-small', 640, 400, true ); // name, width, height, crop
  add_image_size( 'featured-alt-medium', 1280, 600, true );
  add_image_size( 'featured-alt-large', 1440, 600, true );
  add_image_size( 'featured-alt-xlarge', 1920, 600, true );
}
add_action('after_setup_theme','add_additional_image_sizes');



// Disable AutoEmbed
function disable_embeds_code_init() {
// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );
}

add_action( 'admin_init', 'disable_embeds_code_init', 9999 );


function wpdocs_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( ' ... Read More', 'textdomain' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu( $items, $args ) {
    if( $args->theme_location == 'top-bar-r' ) {

      ob_start(); ?>
      <li id="menu-item-search" class='menu-item menu-item-type-custom menu-item-object-custom menu-item-search' role="menuitem">
        <a data-open="header-search-form">
          <h4 class="fa fa-search head-menu-item" style="font-size: 1.3rem;line-height:1.6875rem;" aria-hidden="true"></h4>
        </a>
        <div class="reveal coral" id="header-search-form" data-reveal>
          <h1>What are you looking for?</h1>
          <?php echo get_search_form(); ?>
          <a class="close-button" data-close aria-label="Close modal">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close.svg" alt="close search popup">
          </a>
        </div>
      </li>
      <?php
      return $items.ob_get_clean();
    }

    return $items;
}

function membership_card() {
  ob_start(); ?>
  <div class="membership-card">
    <div class="membership-card-section-background">
      <img src="/wp-content/themes/onelove/assets/images/membership-card.svg" alt="membership card">
    </div>
    <div class="membership-card-section-container">
      <section class="membership-card-name">
        <h3 class="membership-card-firstName">Your</h3>
        <h3 class="membership-card-lastName">Name Here</h3>
      </section>
      <section class="membership-card-date">
        <h4>Member since</h4>
        <h4><?php echo date('Y'); ?></h4>
      </section>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('membership_card','membership_card');



function love_path() {


  ob_start(); ?>
  <div class="love-path-svg">
    <svg class="love-path-svg-image" width="65px" height="1161px" viewBox="0 0 65 1161" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <!-- Generator: Sketch 46.1 (44463) - http://www.bohemiancoding.com/sketch -->
        <title>love path</title>
        <desc>Created with Sketch.</desc>
        <defs>
            <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">
                <stop stop-color="#00A3DF" offset="0%"></stop>
                <stop stop-color="#FF5E5B" offset="100%"></stop>
            </linearGradient>
            <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-2">
                <stop stop-color="#FF5E5B" offset="0%"></stop>
                <stop stop-color="#55C6B6" offset="100%"></stop>
            </linearGradient>
        </defs>
        <g id="desktop-mocks" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Join-Team-One-Love" transform="translate(-252.000000, -2145.000000)">
              <g id="love-path" transform="translate(252.000000, 2145.000000)">
                  <polygon id="Line3" fill="url(#linearGradient-1)" fill-rule="nonzero" points="26 0 26 0 38 0 38 0"></polygon>
                  <polygon id="Line4" fill="url(#linearGradient-2)" fill-rule="nonzero" points="26 0 26 0 38 0 38 0"></polygon>
                  <circle  id="Oval6" fill="#00A3DF" cx="32" cy="15" r="0"></circle>
                  <circle  id="Oval7" fill="#FF5E5B" cx="32" cy="583" r="0"></circle>
                  <polygon id="Path2" fill="#55C6B6" points="32 1104 32 1104.27227 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377"></polygon>
                  <animate xlink:href="#Oval6" id="firstCircle" attributeName="r" dur="1s" from="5" to="15" begin="indefinite"  fill="freeze" />
                  <animate xlink:href="#Line3" id="firstPath"  attributeName="points" dur="2s" from="26 12 26 12 38 12 38 12"  to="26 12 26 582 38 582 38 12" begin="firstCircle.end-1s" fill="freeze" />
                  <animate xlink:href="#Line4" id="secondPath" attributeName="points" dur="2s" from="26 523 26 582 38 582 38 523"  to="26 573 26 1128 38 1128 38 573" begin="firstPath.end" fill="freeze"  />
                  <animate xlink:href="#Oval7" id="secondCircle" attributeName="r" dur="1s" from="0" to="15" begin="firstPath.end-1s"  fill="freeze" />
                  <animate xlink:href="#Path2" id="heartPath" attributeName="points" dur="1s" from="32 1104 32 1104.27227 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377 32 1104.22377"  to="37.754012 1104 37.476497 1104.27227 37.4264355 1104.22377 32.4512988 1109.11964 27.2448997 1104 10.3045131 1104 0 1114.13842 0 1129.02996 32.5002721 1161 65 1129.02996 65 1114.13842 54.6949428 1104" begin="secondPath.end-1s" fill="freeze"  />
              </g>
            </g>
        </g>
    </svg>
  </div>
  <script type="text/javascript">
  !function ($) {
    'use strict'

    var plugin

    var Class = function (el, cb) {
      plugin = this
      this.$el = $(el)
      this.cb = cb
      watch()
      return this
    }

    /**
     * Checks if the element is in.
     *
     * @returns {boolean}
     */
    function isIn () {
      var $win = $(window)
      var elementTop = plugin.$el.offset().top
      var elementBottom = elementTop + plugin.$el.outerHeight()
      var viewportTop = $win.scrollTop()
      var viewportBottom = viewportTop + $win.height()
      return elementBottom > viewportTop && elementTop < viewportBottom
    }

    /**
     * Launch a callback indicating when the element is in and when is out.
     */
    function watch () {
      var _isIn = false

      $(window).on('resize scroll', function () {

        if (isIn() && _isIn === false) {
          plugin.cb.call(plugin.$el, 'entered')
          _isIn = true
        }

        if (_isIn === true && !isIn()) {
          plugin.cb.call(plugin.$el, 'leaved')
          _isIn = false
        }

      })
    }

    // jQuery plugin.
    //-----------------------------------------------------------
    $.fn.isInViewport = function (cb) {
      return this.each(function () {
        var $element = $(this)
        var data = $element.data('isInViewport')
        if (!data) {
          $element.data('isInViewport', (new Class(this, cb)))
        }
      })
    }

    }(window.jQuery)
  </script>
  <script type="text/javascript">
    jQuery(".love-path-svg-image").load(function(){
      var svgCalled = false;
      $('.love-path-svg').isInViewport(function (status) {
        if (status === 'entered' & !svgCalled) {
          calculatePathHeight();
          svgCalled = true;
        }
      });

      jQuery(window).resize(function(){
        calculatePathHeight(false);
      });



      function calculatePathHeight(begin = true ) {
        if ($(window).width() < 800) {
          var reduceWidth = true;
        }
        var getContainer = jQuery('.animated-love-path');
        if ( getContainer.length ) {
          if (reduceWidth) {
            var displacement = getContainer.outerHeight()+15;
            jQuery('#Oval7').attr('cy',displacement);
            jQuery('#firstPath').attr( 'to',"28 12 28 "+ displacement +" 36 "+ displacement +" 36 12");
            getContainer = jQuery('.animated-love-path-2');
            jQuery('#firstCircle,#secondCircle').attr('to','10');
            if ( getContainer.length ) {
              var displacement2 = getContainer.outerHeight()+ 15 + displacement;
              jQuery('#secondPath').attr({
                'from':"28 "+displacement+" 28 "+displacement+" 36 "+displacement+" 36 "+ displacement,
                'to':"28 "+displacement+" 28 "+(displacement2-20)+" 36 "+(displacement2-20)+" 36 "+displacement
              });
              displacement2 -= 45;
              jQuery('#heartPath').attr({
                "from": "32 "+displacement2+" 32 "+displacement2+".27227 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377",
                "to"  : "37.754012 "+(displacement2)+" 37.476497 "+(displacement2)+".27227 37.4264355 "+(displacement2)+".22377 32.4512988 "+(displacement2+5)+".11964 27.2448997 "+(displacement2)+" 10.3045131 "+(displacement2)+" 0 "+(displacement2+10)+".13842 0 "+(displacement2+25)+".02996 32.5002721 "+(displacement2+57)+" 65 "+(displacement2+25)+".02996 65 "+(displacement2+10)+".13842 54.6949428 "+(displacement2),
              });
              jQuery('#Path2').attr({
                "transform": "scale(.5) translate(32 "+(displacement2 + 33)+")",
              });
            }
          }
          else {
            var displacement = getContainer.outerHeight()+15;
            jQuery('#Oval7').attr('cy',displacement);
            jQuery('#firstPath').attr( 'to',"26 12 26 "+ displacement +" 38 "+ displacement +" 38 12");
            getContainer = jQuery('.animated-love-path-2');
            jQuery('#firstCircle,#secondCircle').attr('to','15');
            if ( getContainer.length ) {
              jQuery('#Path2').removeAttr('transform style');
              var displacement2 = getContainer.outerHeight()+ 15 + displacement;
              jQuery('#secondPath').attr({
                'from':"26 "+displacement+" 26 "+displacement+" 38 "+displacement+" 38 "+ displacement,
                'to':"26 "+displacement+" 26 "+displacement2+" 38 "+displacement2+" 38 "+displacement,
              });
              displacement2 -= 45;
              jQuery('#heartPath').attr({
                "from": "32 "+displacement2+" 32 "+displacement2+".27227 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377 32 "+displacement2+".22377",
                "to"  : "37.754012 "+displacement2+" 37.476497 "+displacement2+".27227 37.4264355 "+displacement2+".22377 32.4512988 "+(displacement2+5)+".11964 27.2448997 "+displacement2+" 10.3045131 "+displacement2+" 0 "+(displacement2+10)+".13842 0 "+(displacement2+25)+".02996 32.5002721 "+(displacement2+57)+" 65 "+(displacement2+25)+".02996 65 "+(displacement2+10)+".13842 54.6949428 "+displacement2,
              });
            }
          }
          var firstCircle = document.getElementById('firstCircle');
          if (begin) firstCircle.beginElement();
          else firstCircle.endElement();

        }
      }


    });
  </script>
  <?php

  return ob_get_clean();
}
add_shortcode('love_path','love_path');
