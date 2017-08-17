<?php
/*
Template Name: Home
*/
get_header();



$slider = do_shortcode('[cycloneslider id="homepage"]');

if ( empty($slider) || mb_strpos($slider,'not found') !== false  ) {
  $subtitle = get_post_meta(get_the_ID(),'subtitle','true');
  if ( has_post_thumbnail( $post->ID ) ) : ?>
    <header id="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('featured-alt-small'); ?>, small], [<?php echo the_post_thumbnail_url('featured-alt-medium'); ?>, medium], [<?php echo the_post_thumbnail_url('featured-alt-large'); ?>, large], [<?php echo the_post_thumbnail_url('featured-alt-xlarge'); ?>, xlarge]">
      <div class="overlay">
        <header class="full-page-header-content">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <h3><?php echo $subtitle; ?></h3>
        </header>
      </div>
    </header>
  <?php endif;
}
else {
  echo $slider;
}
?>


<div id="page-full-width" class="homepage" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
      <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
      <?php if ( !has_post_thumbnail( $post->ID ) ): ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <h3><?php echo $subtitle; ?></h3>
      <?php endif; ?>
      <div class="entry-content">
          <?php the_content(); ?>
      </div>
  </article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
