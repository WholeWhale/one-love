<?php

if (has_post_thumbnail( $post->ID )) {



$button_url   = get_post_meta(get_the_ID(),'campaign-button-url','true');
$button_text  = get_post_meta(get_the_ID(),'campaign-button-cta','true');
$description  = get_post_meta(get_the_ID(),'campaign-description','true');

get_template_part( 'template-parts/featured-image' );
?>

<div id="single-post" role="main">

  <div class="conversation-card">
    <div class="card-half">
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php if ($button_text): ?>
        <div class="vc_btn3-container ol_button vc_btn3-center">
            <a href="<?php echo $button_url; ?>" class="vc_general vc_btn3 vc_btn3-size-default vc_btn3-shape-default vc_btn3-style-onelove vc_btn3-color-default">
            <h4><?php echo $button_text; ?></h4>
          </a>
        </div>
      <?php endif; ?>

    </div>
    <?php if ($description): ?>
      <div class="card-half">
        <h3><?php echo $description; ?></h3>
      </div>
    <?php endif; ?>

  </div>

<?php }
else { ?>


  <div id="single-post" role="main">
    <h1 class="entry-title" style="margin-top: 30px;"><?php the_title(); ?></h1>
<?php
}

?>

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
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
