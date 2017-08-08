<div id="single-post" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<header class="snow-background">
      <?php if (!is_page()): ?>
        <?php
        $post_type = get_post_type();
        $post_type_base_name = preg_replace( '/_post_type/','',$post_type );
        ?>
        <h5 id="display-post-category"><?php echo (get_the_terms(get_the_ID(),$post_type_base_name.'_category')[0]->name); ?></h5>
        <?php endif; ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part( 'template-parts/featured-image' ); ?>
        <!-- <?php foundationpress_entry_meta(); ?> -->
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
