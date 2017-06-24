<?php

/**
 * Add additional paraams
 */

function add_button_colors() {
   //Get current values stored in the color param in "Button" element
   $colors = WPBMap::getParam( 'vc_btn', 'color' );
   //Append new value to the 'value' array
   $colors['value'][__( 'Default', 'my-text-domain' )] = 'default';
   //Finally "mutate" param with new values
   vc_update_shortcode_param( 'vc_btn', $colors );
   $styles = WPBMap::getParam( 'vc_btn', 'style' );
   //Append new value to the 'value' array
   $styles['value'][__( 'One Love', 'my-text-domain' )] = 'onelove';
   vc_update_shortcode_param( 'vc_btn', $styles );
   $shapes = WPBMap::getParam( 'vc_btn', 'shape' );
   //Append new value to the 'value' array
   $shapes['value'][__( 'Default', 'my-text-domain' )] = 'default';
   vc_update_shortcode_param( 'vc_btn', $shapes );
   $size = WPBMap::getParam( 'vc_btn', 'size' );
   //Append new value to the 'value' array
   $size['value'][__( 'Default', 'my-text-domain' )] = 'default';
   vc_update_shortcode_param( 'vc_btn', $size );
   $alignment = WPBMap::getParam( 'vc_btn', 'align' );
   //Append new value to the 'value' array
   $alignment['value'][__( 'Default', 'my-text-domain' )] = 'default';
   vc_update_shortcode_param( 'vc_btn', $alignment );

 }
 add_action( 'vc_after_init', 'add_button_colors' );
 /** Note: here we are using vc_after_init because WPBMap::GetParam and
  * mutateParame are available only when default content elements are "mapped"
  * into the system
  */
