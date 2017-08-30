<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.
if ( has_post_thumbnail( $post->ID ) ) : ?>
	<header id="featured-hero" role="banner" style="background-image: url('<?php echo the_post_thumbnail_url('full'); ?>')">
	</header>
<?php endif;
