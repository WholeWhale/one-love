<?php
/*
Template Name: Full Width
*/
get_header();



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
    <?php endif; ?>

    <?php
    $is_this_404_page = false;
    if ( defined( 'PP_404' ) && pp_404_is_active() ) {
      $is_this_404_page = get_the_title() == '404';
    }
    ?>
    <?php if ( !has_post_thumbnail( $post->ID ) && ( !empty(get_the_title()) || !empty($subtitle) ) && !$is_this_404_page ): ?>
      <div class="full-width-no-featured-image navy">
        <div>
          <h1 class="entry-title"><?php the_title(); ?></h1>
          <h3><?php echo $subtitle; ?></h3>
        </div>
      </div>
    <?php endif; ?>
<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
    <?php if ( $is_this_404_page ): ?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <h3><?php echo $subtitle; ?></h3>
    <?php endif; ?>
      <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
      <div class="entry-content">
          <?php the_content(); ?>
      </div>
  </article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
