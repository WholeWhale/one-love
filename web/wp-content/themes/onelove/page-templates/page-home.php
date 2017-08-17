<?php
/*
Template Name: Home
*/
get_header();

  $button1_text = get_post_meta(get_the_ID(),'button-1-text','true');
  $button1_link = get_post_meta(get_the_ID(),'button-1-link','true');
  $button2_text = get_post_meta(get_the_ID(),'button-2-text','true');
  $button2_link = get_post_meta(get_the_ID(),'button-2-link','true');
  if ( has_post_thumbnail( $post->ID ) ) : ?>
    <header id="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('featured-alt-small'); ?>, small], [<?php echo the_post_thumbnail_url('featured-alt-medium'); ?>, medium], [<?php echo the_post_thumbnail_url('featured-alt-large'); ?>, large], [<?php echo the_post_thumbnail_url('featured-alt-xlarge'); ?>, xlarge]">
      <div class="overlay remove-overlay">
        <header class="full-page-header-content">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="hero-overlay-buttons">

                <div class="vc_btn3-container ol_button vc_btn3-default">
                   <a class="vc_general vc_btn3 vc_btn3-size-default vc_btn3-shape-default vc_btn3-style-onelove vc_btn3-color-default" href="<?php echo $button1_link; ?>" title="">
                     <h4><?php echo $button1_text; ?></h4>
                   </a>
                 </div>


                <div class="vc_btn3-container ol_button vc_btn3-default">
                  <a class="vc_general vc_btn3 vc_btn3-size-default vc_btn3-shape-default vc_btn3-style-onelove vc_btn3-color-coral" href="<?php echo $button2_text; ?>" title="">
                     <h4><?php echo $button2_text; ?></h4>
                   </a>
                 </div>

            </div>
        </header>
      </div>
    </header>
  <?php endif;
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
