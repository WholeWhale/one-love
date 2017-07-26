<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $el_id = $width = $css = $offset = $css_animation = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if ( vc_shortcode_custom_css_has_property( $css, array(
	'border',
	'background',
) ) ) {
	$css_classes[] = 'vc_col-has-fill';
}

if ( $equalize_children == 'true' || $equalize_children == 'trueByRow' ) {
  $equalize_children_attribs = 'data-equalizer';
  if ( !empty( $equalize_id ) ) {
    $equalize_children_attribs .= '="'.$equalize_id.'"';
  }
  if ( $equalize_children == 'trueByRow' ) {
    $equalize_children_attribs .= ' data-equalize-by-row="true"';
  }
}
else {
  $equalize_children_attribs = '';
}

if ( $flip_card == 'true' ) {
  $card_attrib = ' data-flip-card ';
}
else {
  $card_attrib = '';
}

if ( $card_flip_direction ) {
  $flip_direction = 'data-flip-'.$card_flip_direction;
}
else {
  $flip_direction = '';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . $flip_direction.'>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '" '. $extra_attribs .' '.$card_attrib.''. $equalize_children_attribs .'>';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
