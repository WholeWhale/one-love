<?php

function foundationpress_mobile_nav() {
  wp_nav_menu( array(
    'container'      => false,                         // Remove nav container
    'menu'           => __( 'mobile-nav', 'foundationpress' ),
    'menu_class'     => 'vertical menu',
    'theme_location' => 'mobile-nav',
    'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>'.get_search_form(false).do_shortcode('[social_media]'),
    'fallback_cb'    => false,
    'walker'         => new Foundationpress_Mobile_Walker(),
  ));
}
