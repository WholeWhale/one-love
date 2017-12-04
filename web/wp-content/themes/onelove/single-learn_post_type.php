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

  $author_avatar = ol_get_avatar(get_the_author_meta('ID'),100,'404','Author of article');
  $author_name = get_the_author_meta('display_name');
  $author_description = get_the_author_meta('description');
  $twitter_handle = get_the_author_meta('twitter');
  $website_url = get_the_author_meta('url');
  $twitter_empty = empty($twitter_handle);
  $website_url_empty = empty($website_url);

  if ( empty($author_name) || ( empty($author_description) && $twitter_empty && $website_url_empty ) ) {
    return;
  }
  else {
    # code...
    ?>
    <section class="author-bio">
      <div class="about-author-headline">
        <h3>About the author</h3>
      </div>
      <div class="author-container">
        <div class="about-author-image">
          <?php
          echo $author_avatar;
        ?>
        </div>
        <div class="about-author-text">
          <h3><?php echo $author_name; ?></h3>
          <div class="author-handles">
            <p>
              <?php
              if ( !$twitter_empty ) {
                echo '
                <a href="https://twitter.com/'.$twitter_handle.'" rel="nofollow" target="_blank">
                  @'.$twitter_handle.'
                </a>';
              }
              if ( !$twitter_empty && !$website_url_empty ) {
                echo ' &vert; ';
              }
              if ( !$website_url_empty ) {
                echo '<a href="'.$website_url.'" rel="nofollow" target="_blank">';
                $website_url = parse_url($website_url);
                echo $website_url['host'].$website_url['path'].'</a>';
              }
              ?>
            </p>
          </div>
          <?php
            if ( !empty($author_description) ) {
              echo $author_description;
            }
          ?>
        </div>
      </div>
    </section>
    <?php
  }
}
