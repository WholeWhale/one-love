<?php
/*
Template Name: Full Width
*/
get_header();



$subtitle = get_post_meta(get_the_ID(),'subtitle','true');


    if ( has_post_thumbnail( $post->ID ) ) : ?>
    	<header id="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('featured-small'); ?>, small], [<?php echo the_post_thumbnail_url('featured-medium'); ?>, medium], [<?php echo the_post_thumbnail_url('featured-large'); ?>, large], [<?php echo the_post_thumbnail_url('featured-xlarge'); ?>, xlarge]">
        <div class="overlay">
          <header class="full-page-header-content">
              <h1 class="entry-title"><?php the_title(); ?></h1>
              <h3><?php echo $subtitle; ?></h3>
          </header>
        </div>
      </header>
    <?php endif; ?>


<div id="page-full-width" role="main">

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
      <footer>
          <?php
            wp_link_pages(
              array(
                'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ),
                'after'  => '</p></nav>',
              )
            );
          ?>
          <p><?php the_tags(); ?></p>
      </footer>
      <?php do_action( 'foundationpress_page_before_comments' ); ?>
      <?php comments_template(); ?>
      <?php do_action( 'foundationpress_page_after_comments' ); ?>
  </article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
