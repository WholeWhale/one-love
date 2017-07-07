<?php
/*
Plugin Name: Cyclone Slider Template: One Love
Version: 1.0
Description: Custom Slider Template based on the One Love Theme.
Author: Luis Delacruz
Author URI: https://luisdelacruz.io
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

add_filter( 'cycloneslider_template_list', 'cycloneslider_template_onelove' );
function cycloneslider_template_onelove( $template_list ) {

    $template_list[ 'onelove' ] = array(
        'name'          => 'One Love',
        'path'          => realpath( plugin_dir_path( __FILE__ ) ),
        'url'           => plugin_dir_url( __FILE__ ),
        'supports'      => array(
            'image',
            'custom',
            'youtube',
        ),
        'location_name' => 'plugin',
        'scripts'       => array(

        ),
        'styles'        => array(

        )
    );

    return $template_list;
}


/**
 * Re-initalize the main cyclone slider function
 * in order to allow modification/extension of back-end params.
 */


$cyclone_slider_plugin_instance = null;
remove_action('plugins_loaded', 'cs3_init');
add_action('plugins_loaded','cs3_initialize');

function cs3_initialize() {
  global $cyclone_slider_plugin_instance;

  $plugin = new CycloneSlider_Plugin();
  $plugin['path'] = realpath(plugin_dir_path(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'cyclone-slider-2' . DIRECTORY_SEPARATOR;
  $plugin['url'] = plugin_dir_url(dirname(__FILE__)).'cyclone-slider-2/';
  $plugin['plugin_headers'] = 'cs3_service_plugin_headers';
  $plugin['version'] = 'cs3_service_plugin_version';
  $plugin['debug'] = false;
  $plugin['textdomain'] = 'cs3_service_plugin_text_domain';

  // Load as early as possible
  load_plugin_textdomain( $plugin['textdomain'], false, basename($plugin['path']).'/languages/' ); // Load language files

  $plugin['slug'] = 'cs3_service_plugin_slug';
  $plugin['nonce_name'] = 'cyclone_slider_builder_nonce';
  $plugin['nonce_action'] = 'cyclone-slider-save';
  $plugin['wp_upload_location'] = 'cs3_service_wp_upload_location';
  $plugin['wp_content_dir'] = 'cs3_service_wp_content_dir';
  $plugin['wp_content_url'] = content_url();
  $plugin['cyclone_slider_dir'] = 'cs3_service_cyclone_slider_dir'; // Folder where plugin related functions are performed
  $plugin['view_folder'] = $plugin['path'].'views';
  $plugin['view'] = 'cs3_service_view';

  $plugin['image_resizer'] = 'cs3_service_image_resizer';
  $plugin['image_editor'] = 'CycloneSlider_ImageEditor';
  $plugin['image_sizes'] = array(
      '40_40_crop' => array( // Used by thumbnail template
          'width' => 40,
          'height' => 40,
          'resize_option' => 'crop'
      ),
      '60_60_crop' => array( // Used by Galleria template
          'width' => 60,
          'height' => 60,
          'resize_option' => 'crop'
      )
  );

  $plugin['data'] = 'cs3_service_data_mod';

  $plugin['nextgen_integration'] = 'cs3_service_nextgen';

  $plugin['exporter'] = 'cs3_service_exporter';
  $plugin['exports_dir'] = $plugin['cyclone_slider_dir'].'/exports';
  $plugin['export_json_file'] = 'export.json';

  $plugin['importer'] = 'cs3_service_importer';
  $plugin['imports_dir'] = $plugin['cyclone_slider_dir'].'/imports';
  $plugin['imports_extracts_dir'] = $plugin['imports_dir'].'/extracts';
  $plugin['import_zip_name'] = 'import.zip';

  // Order is important. core is overridden by active-theme which in turn is overridden by wp-content.
  $plugin['template_locations'] = array(
      array(
          'path' => $plugin['path'].'templates'.DIRECTORY_SEPARATOR, // This resides in the plugin
          'url' => $plugin['url'].'templates/',
          'location_name' => 'core'
      ),
      array(
          'path' => realpath(get_stylesheet_directory()).DIRECTORY_SEPARATOR.'cycloneslider'.DIRECTORY_SEPARATOR, // This resides in the current theme or child theme. Gets deleted when theme is deleted.
          'url' => get_stylesheet_directory_uri()."/cycloneslider/",
          'location_name' => 'active-theme'
      ),
      array(
          'path' => $plugin['wp_content_dir'].DIRECTORY_SEPARATOR.'cycloneslider'.DIRECTORY_SEPARATOR, // This resides in the wp-content folder to prevent deleting when upgrading themes. Recommended location
          'url' => $plugin['wp_content_url']."/cycloneslider/",
          'location_name' => 'wp-content'
      )
  );

  $plugin['settings_page'] = 'cs3_service_settings_page';
  $plugin['settings_page_properties'] = array(
      'parent_slug' => 'edit.php?post_type=cycloneslider',
      'page_title' =>  __('Cyclone Slider Settings', 'cycloneslider'),
      'menu_title' =>  __('Settings', 'cycloneslider'),
  'capability' => 'manage_options',
      'menu_slug' => 'cycloneslider-settings',
      'option_group' => 'cyclone_option_group',
      'option_name' => 'cyclone_option_name'
  );

  $plugin['export_page'] = 'cs3_service_export_page';
  $plugin['export_page_properties'] = array(
      'parent_slug' => 'edit.php?post_type=cycloneslider',
      'page_title' => __('Cyclone Slider Export', 'cycloneslider'),
  'menu_title' => __('Export/Import', 'cycloneslider'),
      'capability' => 'manage_options',
      'menu_slug' => 'cycloneslider-export',
      'transient_name' => 'cycloneslider_export_transient',
      'nonce_name' => 'cycloneslider_export_nonce',
      'nonce_action' => 'cycloneslider_export',
      'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-export' )
  );

  //$plugin['export_page_nextgen'] = 'cs3_service_export_page_nextgen';
  $plugin['export_page_nextgen_properties'] = array(
      'parent_slug' => '',
      'page_title' => __('Cyclone Slider Nextgen Export', 'cycloneslider'),
      'menu_title' => __('Export Nextgen', 'cycloneslider'),
      'capability' => 'manage_options',
      'menu_slug' => 'cycloneslider-export-nextgen',
      'transient_name' => 'cycloneslider_export_nextgen_transient',
      'nonce_name' => 'cycloneslider_export_nextgen_nonce',
      'nonce_action' => 'cycloneslider_export_nextgen',
      'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-export-nextgen' )
  );

  $plugin['import_page'] = 'cs3_service_import_page';
$plugin['import_page_properties'] = array(
      'parent_slug' => '',
  'page_title' => __('Cyclone Slider Import', 'cycloneslider'),
  'menu_title' => __('Import', 'cycloneslider'),
  'capability' => 'manage_options',
  'menu_slug' => 'cycloneslider-import',
      'nonce_name' => 'cycloneslider_import_nonce',
      'nonce_action' => 'cycloneslider_import',
      'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-import' )
  );

  $plugin['zip_archive'] = 'cs3_service_zip_archive';
  $plugin['youtube'] = new CycloneSlider_Youtube();
  $plugin['vimeo'] = new CycloneSlider_Vimeo();
  $plugin['asset_loader'] = 'cs3_service_asset_loader';
  $plugin['admin'] = 'cs3_service_admin_mod';
  $plugin['frontend'] = 'cs3_service_frontend';
  $plugin['updater'] = '';
  $plugin['widgets'] = new CycloneSlider_Widgets();

  require_once($plugin['path'].'src/functions.php'); // Function not autoloaded from the old days. Deprecated

  $plugin->run();

  $cyclone_slider_plugin_instance = $plugin;
}

function cs3_service_admin_mod( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }

    $object = new CycloneSlider_Admin_Mod(
        $plugin['asset_loader'],
        $plugin['data'],
        $plugin['debug'],
        $plugin['view'],
        $plugin['nonce_name'],
        $plugin['nonce_action'],
        $plugin['url']
    );
    return $object;
}

function cs3_service_data_mod( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }

    $object = new CycloneSlider_Data_Mod(
        $plugin['nonce_name'],
        $plugin['nonce_action'],
        $plugin['image_resizer'],
        $plugin['template_locations'],
        $plugin['settings_page_properties']
    );
    return $object;
}

define("ONELOVE_VIEWS_DIR", "../../cyclone-slider-template-onelove/views/");
class CycloneSlider_Admin_Mod extends CycloneSlider_Admin {

  /**
   * Get slide image thumb from id. False on fail
   *
   * @param $attachment_id
   *
   * @return array|bool|false|string
   */
  protected function get_slide_img_thumb($attachment_id){
      $attachment_id = (int) $attachment_id;
      if($attachment_id > 0){
          $image_url = wp_get_attachment_image_src( $attachment_id, 'medium', true );
          $image_url = (is_array($image_url)) ? $image_url[0] : '';
          return $image_url;
      }
      return false;
  }

  /**
   * Metabox for slides
   *
   * @param $post
   */
  public function render_slides_meta_box($post){

      try {
          $slider = $this->data->get_slider($post->ID);

          if($slider === NULL){
              $this->view->render('slides.php', array('error'=> sprintf(__('Slider "%s" not found.','cycloneslider'), $post->ID) ));
          } else {
              $slides_html = '';
              foreach($slider['slides'] as $i=>$slide) {

                  $image_url = $this->get_slide_img_thumb($slide['id']);
                  $image_url = apply_filters('cycloneslider_preview_url', $image_url, $slide);
                  $box_title = __('Slide', 'cycloneslider').' '.($i+1);
                  if( '' != trim($slide['title']) and 'image' == $slide['type'] ){
                      $box_title = $box_title. ' - '.$slide['title'];
                  }
                  if( '1' == $slide['hidden'] ){
                      $box_title = $box_title. ' - '.__('[Hidden]', 'cycloneslider');
                  }
                  $box_title = apply_filters('cycloneslider_box_title', $box_title);

                  $vars = array();
                  $vars['i'] = $i;
                  $vars['slider'] = $slider;
                  $vars['slide'] = $slide;
                  $vars['image_url'] = $image_url;
                  $vars['full_image_url'] = wp_get_attachment_url($slide['id']);
                  $vars['testimonial_img_url'] = $this->get_slide_img_thumb($slide['testimonial_img']);
                  $vars['full_testimonial_img_url'] = wp_get_attachment_url($slide['testimonial_img']);
                  $vars['box_title'] = $box_title;
                  $vars['debug'] = ($this->debug) ? cyclone_slider_debug($slide) : '';
                  $vars['effects'] = $this->data->get_slide_effects();

                  $slides_html .= $this->view->get_render(ONELOVE_VIEWS_DIR . 'slide-edit.php', $vars);
              }

              $vars = array();
              $vars['error'] = '';
              $vars['slides'] = $slides_html;
              $vars['post_id'] = $post->ID;
              $vars['nonce_name'] = $this->nonce_name;
              $vars['nonce'] = wp_create_nonce( $this->nonce_action );

              $this->view->render('slides.php', $vars);
          }
      } catch (Exception $e) {
          $this->view->render('slides.php', array('error'=> $e->getMessage()));
      }
  }
}


/**
 * add additional fields to save
 */
class CycloneSlider_Data_Mod extends CycloneSlider_Data {
  /**
   * Add Slider Slides
   *
   * API to add slides
   *
   * @param int $slider_id Slider post ID
   * @param array $slides Slides array
   */
  public function add_slider_slides( $slider_id, array $slides ){

      $slides_to_save = array();

      $i=0;//always start from 0
      foreach($slides as $slide){
          $slide = wp_parse_args(
              $slide,
              $this->get_slide_defaults()
          );
          $slides_to_save[$i]['id']                      = (int) ($slide['id']);
          $slides_to_save[$i]['type']                    = sanitize_text_field($slide['type']);
          $slides_to_save[$i]['hidden']                  = (int) ($slide['hidden']);

          $slides_to_save[$i]['link']                    = esc_url_raw($slide['link']);
          $slides_to_save[$i]['title']                   = wp_kses_post($slide['title']);
          $slides_to_save[$i]['description']             = wp_kses_post($slide['description']);
          $slides_to_save[$i]['button_cta']              = sanitize_text_field($slide['button_cta']);
          $slides_to_save[$i]['button_img_cta']          = sanitize_text_field($slide['button_img_cta']);
          $slides_to_save[$i]['button_url']              = esc_url_raw($slide['button_url']);
          $slides_to_save[$i]['button_img_url']          = esc_url_raw($slide['button_img_url']);
          $slides_to_save[$i]['link_target']             = sanitize_text_field($slide['link_target']);

          $slides_to_save[$i]['img_alt']                 = sanitize_text_field($slide['img_alt']);
          $slides_to_save[$i]['img_title']               = sanitize_text_field($slide['img_title']);
          $slides_to_save[$i]['img_fallback_url']        = esc_url_raw($slide['fallback_image_url']);

          $slides_to_save[$i]['enable_slide_effects']    = (int) ($slide['enable_slide_effects']);
          $slides_to_save[$i]['fx']                      = sanitize_text_field($slide['fx']);
          $slides_to_save[$i]['speed']                   = sanitize_text_field($slide['speed']);
          $slides_to_save[$i]['timeout']                 = sanitize_text_field($slide['timeout']);
          $slides_to_save[$i]['tile_count']              = sanitize_text_field($slide['tile_count']);
          $slides_to_save[$i]['tile_delay']              = sanitize_text_field($slide['tile_delay']);
          $slides_to_save[$i]['tile_vertical']           = sanitize_text_field($slide['tile_vertical']);

          $slides_to_save[$i]['video_thumb']             = esc_url_raw($slide['video_thumb']);
          $slides_to_save[$i]['video_url']               = esc_url_raw($slide['video_url']);
          $slides_to_save[$i]['video']                   = $slide['video'];

          $slides_to_save[$i]['custom']                  = $slide['custom'];

          $slides_to_save[$i]['youtube_url']             = esc_url_raw($slide['youtube_url']);
          $slides_to_save[$i]['youtube_related']         = sanitize_text_field($slide['youtube_related']);


          $slides_to_save[$i]['vimeo_url']               = esc_url_raw($slide['vimeo_url']);

          $slides_to_save[$i]['testimonial']             = wp_kses_post($slide['testimonial']);
          $slides_to_save[$i]['testimonial_author']      = sanitize_text_field($slide['testimonial_author']);
          $slides_to_save[$i]['testimonial_link']        = esc_url_raw($slide['testimonial_link']);
          $slides_to_save[$i]['testimonial_link_target'] = sanitize_text_field($slide['testimonial_link_target']);
          $slides_to_save[$i]['testimonial_img']         = (int) $slide['testimonial_img'];

          $i++;
      }
      $slides_to_save = apply_filters('cycloneslider_slides', $slides_to_save); //do filter before saving

      delete_post_meta($slider_id, '_cycloneslider_metas');
      update_post_meta($slider_id, '_cycloneslider_metas', $slides_to_save);
  }
}
