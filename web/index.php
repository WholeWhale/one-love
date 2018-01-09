<?php
// Tells WordPress to load the WordPress theme and output it.
define('WP_USE_THEMES', true);

if ($_SERVER['REQUEST_URI'] === '/autodiscover/autodiscover.xml') {
  http_response_code(401);
} else {
  // Loads the WordPress Environment and Template
  require( dirname( __FILE__ ) . '/wp/wp-blog-header.php' );
}

