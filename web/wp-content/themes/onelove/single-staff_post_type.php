<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

?>

<div class="staff-container">
  <div class="staff-container-column">
    <?php get_template_part( 'template-parts/featured-image' ); ?>
  </div>
  <div id="single-post" role="main" class="staff-container-column">
    <?php do_action( 'foundationpress_before_content' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
    		<header>
    			<h1 class="entry-title"><?php the_title(); ?></h1>
          <h3><?php echo  get_post_meta(get_the_ID(),'staff-position','true');  ?></h3>
    		</header>
    		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
    		<div class="entry-content">
    			<?php the_content(); ?>
    			<?php edit_post_link( __( 'Edit', 'foundationpress' ), '<span class="edit-link">', '</span>' ); ?>
    		</div>
    		<?php do_action( 'foundationpress_post_before_comments' ); ?>
    		<?php comments_template(); ?>
    		<?php do_action( 'foundationpress_post_after_comments' ); ?>
    	</article>
    <?php endwhile;?>

    <a href="/staff"><h3 class="return-staff">< Back To All Staff</h3></a>
    <?php do_action( 'foundationpress_after_content' ); ?>
  </div>
</div>



<?php get_footer();
