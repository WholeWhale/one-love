<?php
/**
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

add_action('foundationpress_post_before_comments','learn_author_info');

get_template_part("template-parts/learn");

get_footer();

function learn_author_info() {
  ?>
  <section class="author-bio">
    <div class="about-author-headline">
      <h3>About the author</h3>
    </div>
    <div class="author-container">
      <div class="about-author-image">
        <?php echo get_avatar(get_the_author_meta('ID'),100,'Author of article'); ?>
      </div>
      <div class="about-author-text">
        <h3><?php echo get_the_author_meta('display_name') ?></h3>
        <div class="author-handles">
          <p>
            <?php
            $twitter_handle = get_the_author_meta('twitter');
            $website_url = get_the_author_meta('url');
            ?>
            <a href="https://twitter.com/<?php echo $twitter_handle;?>" rel="nofollow" target="_blank">
              @<?php echo $twitter_handle; ?>
            </a>
            &vert;
            <a href="<?php echo $website_url; ?>" rel="nofollow" target="_blank">
              <?php $website_url = parse_url($website_url); echo $website_url['host'].$website_url['path']; ?>
            </a>
          </p>  
        </div>
        <?php echo get_the_author_meta('description') ?>
      </div>
    </div>
  </section>
  <?php
}
