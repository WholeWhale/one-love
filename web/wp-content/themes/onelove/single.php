<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */


global $post;

$cat = get_the_terms($post->ID,'news_category');

if ( !empty($cat) ) {
  foreach ($cat as $value) {
    if ( $value->name == 'Press' ) {
      $category_post_content = wp_strip_all_tags( apply_filters( 'the_content', get_post_field( 'post_content', $post->ID ) ) );
      $redirect_url = trim( filter_var($category_post_content, FILTER_SANITIZE_URL) );
      if ( !empty($redirect_url) ) {
        wp_redirect($redirect_url, 301);
        exit;
      }

    }
  }
}

get_header();

?>



<?php get_template_part( 'template-parts/featured-image' ); ?>

<div id="single-post" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
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

<?php do_action( 'foundationpress_after_content' ); ?>
</div>
<?php get_footer();
