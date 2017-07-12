<?php



// Create the function that will filter the options
function swp_options_function($swp_options) {
  $swp_options['options']['swp_styles']['cttTheme']['content']['style-onelove'] = 'Onelove: Default';
  return $swp_options;
}
// Queue up your filter to be ran on the swp_options hook.
add_filter('swp_options', 'swp_options_function', 8);



if(function_exists('social_warfare')):
    function append_social_share_to_ctt( $output, $tag, $attr ) {
      if ( 'clickToTweet' == $tag ) {
        $args = array(
          'echo' => false,

        );
        return
          $output . do_shortcode('[social_warfare buttons="Twitter"]');

      }
      return $output;
    }
    add_filter('do_shortcode_tag','append_social_share_to_ctt',10,3);
endif;
