<?php

function max_title_length( $title ) {
  $max = 69;
  if( strlen( $title ) > $max ) {
    return substr( $title, 0, $max ). "&hellip;";
  }
  else {
    return $title;
  }
}

function post_title_limited_length( $value, $data ) {
	/**
	 * @var null|Wp_Post $post ;
	 * @var string $data ;
	 */
	extract( array_merge( array(
		'post' => null,
		'data' => '',
	), $data ) );

  add_filter( 'the_title', 'max_title_length');

	return the_title( '', '', false );
}
add_filter( 'vc_gitem_template_attribute_post_title', 'post_title_limited_length', 99, 99 );
