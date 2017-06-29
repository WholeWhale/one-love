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

add_action( 'vc_before_init', 'card_component' );

function card_component() {
  vc_map( array(
     "name" => __("Action Card"),
     "base" => "action_card",
     "category" => __('Content'),
     "weight" => 100,
     "params" => array(
       array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => __( "Card Icon", "my-text-domain" ),
            "param_name" => "icon",
            "value" => __( "", "my-text-domain" ),
            "description" => __( "The icon that will display at the upper-left side of the card.", "my-text-domain" )
         ),
       array(
          "type" => "dropdown",
          "holder" => "div",
          "class" => "",
          "heading" => __( "Card Icon Font", "my-text-domain" ),
          "param_name" => "font_family",
          "value" => array(
            "Material Font Awesome" => "Material-Design-Iconic-Font",
            "Overpass"  => "Overpass,sans-serif",
            "Lato" => "Lato,sans-serif",
            "Font Awesome" => "FontAwesome",
          ),
          "description" => __( "The font to use for the card icon", "my-text-domain" )
       ),
       array(
          "type" => "dropdown",
          "holder" => "div",
          "class" => "",
          "heading" => __( "Card Color", "my-text-domain" ),
          "param_name" => "color",
          "value" => array(
            "Green"  => "#55c6b6",
            "Red" => "#ff5e5b"
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
           "description" => __("Displays the content within a card-like block.")

        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __( "Extra Classes", "my-text-domain" ),
             "param_name" => "extra_classes",
             "description" => __("Style particular content element differently - add a class name and refer to it in custom CSS.")
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
      'icon' => '',
      'color' => '#55c6b6',
      'font_family' => 'Material-Design-Iconic-Font',
      'extra_classes' => ''
   ), $atts ) );


  if ($font_family == 'FontAwesome' || 'Material-Design-Iconic-Font') {
    $icon =  '\f'.$icon;
  }

  $unique_iden = random();
  ob_start();

  echo "
  <style media='screen'>
    #".$unique_iden.".action-card { border-top-color: ".$color."; }
    #".$unique_iden.".action-card:before { content: '".$icon ."'; background: ".$color."; font-family: '".$font_family."';}
  </style>
  <div id='" . $unique_iden ."' class='action-card vc_card_spacing ".$extra_classes."'>
    ". $content ."
  </div>";

  return ob_get_clean();

}
