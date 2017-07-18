<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div id="<?php echo esc_attr( $slider_html_id ); ?>" tabindex="0" class="cycloneslider  ">
  <div class="ol-slider cycloneslider-slides cycle-slideshow"
       data-cycle-fx="<?php echo esc_attr( $slider_settings['fx'] ); ?>"
       data-cycle-speed="<?php echo esc_attr( $slider_settings['speed'] ); ?>"
       data-cycle-timeout="<?php echo esc_attr( $slider_settings['timeout'] ); ?>"
       data-cycle-delay="<?php echo esc_attr( $slider_settings['delay'] ); ?>"
       data-cycle-hide-non-active="true"
       data-cycle-log="false"
       data-cycle-next="#<?php echo esc_attr( $slider_html_id ); ?> .slider-next"
       data-cycle-prev="#<?php echo esc_attr( $slider_html_id ); ?> .slider-prev"
       data-cycle-pause-on-hover="<?php echo esc_attr( $slider_settings['hover_pause'] ); ?>"
       data-cycle-slides="div.cycloneslider-slide"
       data-cycle-auto-height="false"
       data-cycle-pager=".slider-pager"
       data-cycle-pager-template="<a><img class='slider-pager-icon'/></a>"
  >
  <?php if ($slider_settings['show_prev_next']) : ?>
    <span class="slider-prev"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/left-arrow.png" alt="Select Previous Slide"></span>
    <span class="slider-next"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/right-arrow.png" alt="Select Next Slide"></span>
    <span class="slider-pager"></span>
  <?php endif; ?>
      <?php foreach($slides as $i=>$slide): ?>
          <?php if ( 'image' == $slide['type'] ) : ?>
              <div class="cycloneslider-slide cycloneslider-slide-image" <?php echo $slide['slide_data_attributes']; ?>>
                  <?php if( 'lightbox' == $slide['link_target'] ): ?>
                      <a class="cycloneslider-caption-more magnific-pop" href="<?php echo esc_url( $slide['full_image_url'] ); ?>" alt="<?php echo $slide['img_alt'];?>">
                  <?php elseif ( '' != $slide['link'] ) : ?>
                      <?php if( '_blank' == $slide['link_target'] ): ?>
                          <a class="cycloneslider-caption-more" target="_blank" href="<?php echo esc_url( $slide['link'] );?>">
                      <?php else: ?>
                          <a class="cycloneslider-caption-more" href="<?php echo esc_url( $slide['link'] );?>">
                      <?php endif; ?>
                  <?php endif; ?>

                  <?php if(!empty($slide['title']) or !empty($slide['description']) or !empty($slide['image_button_cta'])) : ?>
                    <div class="main-video-slide">
                      <div class="overlay-content">
                        <div class="overlay-content-container">
                        <h1 class="title"><?php echo $slide['title']; ?></h1>
                        <h2><?php echo $slide['description']; ?></h2>
                        <?php if (!empty($slide['button_img_cta'])): ?>
                          <div class="vc_btn3-container ol_button vc_btn3-default">
                            <a class="vc_general vc_btn3 vc_btn3-size-default vc_btn3-shape-default vc_btn3-style-onelove vc_btn3-color-default" href="<?php if (!empty($slide['button_img_url'])) echo $slide['button_img_url']; ?>" title="">
                              <h4><?php echo $slide['button_img_cta']; ?></h4>
                            </a>
                          </div>
                        <?php endif; ?>
                        </div>
                        </div>
                          <div class="slider-image" style="background-image: url('<?php echo $slide['image_url']; ?>');"></div>
                      </div>
                  <?php else: ?>
                    <div class="slider-image" style="background-image: url('<?php echo $slide['image_url']; ?>');"></div>
                  <?php endif; ?>
                  <?php if( 'lightbox' == $slide['link_target'] or ('' != $slide['link']) ) : ?>
                      </a>
                  <?php endif; ?>
              </div>
          <?php elseif ( 'custom' == $slide['type'] ) : ?>
              <div class="cycloneslider-slide cycloneslider-slide-custom" <?php echo $slide['slide_data_attributes']; ?>>
                  <?php echo $slide['custom']; ?>
              </div>
            <?php elseif ( 'youtube' == $slide['type'] ) : ?>
              <div class="cycloneslider-slide cycloneslider-slide-youtube <?php echo $i; ?>" <?php echo $slide['slide_data_attributes']; ?>>
                <?php
                  $youtube = new CycloneSlider_Youtube();
                  $meta_value = $youtube->get_youtube_id($slide['youtube_url']);
                  ?>
                  <div class="main-video-slide">
                    <div class="overlay-content">
                      <div class="overlay-content-container">
                        <?php if(!empty($slide['title']) or !empty($slide['description'])) : ?>
                          <h1 class="title"><?php echo $slide['title']; ?></h1>
                          <h2><?php echo $slide['description']; ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($slide['button_cta'])): ?>
                          <div class="vc_btn3-container ol_button vc_btn3-default">
                            <a class="vc_general vc_btn3 vc_btn3-size-default vc_btn3-shape-default vc_btn3-style-onelove vc_btn3-color-default" href="<?php if (!empty($slide['button_url'])) echo $slide['button_url']; ?>" title="">
                              <h4><?php echo $slide['button_cta']; ?></h4>
                            </a>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                    <?php if ($i == 0 ): ?>
                      <div class="featured-video-overlay">
                        <?php if ($slide['id_img']): ?>
                          <div class="slider-image hide-for-medium" style="background-image: url('<?php echo $slide['id_img']; ?>');"></div>
                        <?php endif; ?>

                        <div class="prevent-touch <?php if ($slide['id_img']) echo "show-for-medium"; ?>">
                          <div class="video-background">
                            <div class="video-foreground">
                              <div id="<?php echo $slider_html_id . '-iframe-' . $youtube_count;?>"></div>
                            </div>
                          </div>

                        </div>
                      </div>
                    <?php else: ?>
                      <div>
                        <?php if ($slide['id_img']): ?>
                          <div class="slider-image hide-for-medium" style="background-image: url('<?php echo $slide['id_img']; ?>');"></div>
                        <?php endif; ?>

                        <div class="prevent-touch <?php if ($slide['id_img']) echo "show-for-medium"; ?>"><div id="<?php echo $slider_html_id . '-iframe-' . $youtube_count;?>"></div></div>
                      </div>
                    <?php endif; ?>
                  </div>
                  <script>
                        <?php if ($i == 0 & 'youtube' == $slide['type']): ?>
                        jQuery(function($){
                            $('.cycle-slideshow').on('cycle-initialized',function(event, optionHash){
                              $('.cycle-slideshow').cycle('pause');
                            });
                        });
                        <?php endif; ?>

                        var tag = document.createElement('script');
                        tag.src = "https://www.youtube.com/player_api";
                        var firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                        var player;
                        function onYouTubePlayerAPIReady() {
                          player = new YT.Player("<?php echo $slider_html_id . '-iframe-' . $youtube_count;?>", {
                            width: '100%',
                            height: '100%',
                            playerVars: {
                              'autoplay'      : 1,
                              'showinfo'      : 0,
                              'controls'      : 0,
                              'autohide'      : 1,
                              'loop'          : 0,
                              'disablekb'     : 1,
                              'enablejsapi'   : 1,
                              'modestbranding': 1,
                              'playsinline'   : 1,
                              'rel'           : 0,
                            },
                            videoId: '<?php echo $meta_value; ?>',
                            events: {
                              'onReady'       : onPlayerReady,
                              'onStateChange' : onPlayerStateChange
                            }
                        });

                        function onPlayerReady(event) {

                            function hide_vid_if_hidden() {

                              var visibility = jQuery("#<?php echo $slider_html_id . '-iframe-' . $youtube_count;?>").closest('.prevent-touch').is(':visible');

                              if ( !visibility ) {
                                event.target.stopVideo();
                              }
                              else {
                                event.target.playVideo().mute();
                              }
                            }
                            hide_vid_if_hidden();
                            jQuery(window).resize(function(){
                              hide_vid_if_hidden();
                            });
                        }
                        var done = false;
                        function onPlayerStateChange(event) {
                          if (event.data == YT.PlayerState.ENDED && !done) {
                            console.log('video finished');
                            done = true;
                            displayLastFrame();
                            <?php if ($i == 0 & 'youtube' == $slide['type']): ?>
                            resumeCycleSlider();
                            <?php endif; ?>
                          }
                          if (event.data == YT.PlayerState.PLAYING && !done) {
                            ensureVideoIsMuted();
                          }
                        }
                        function ensureVideoIsMuted() {
                          if ( !player.isMuted() ) {
                            player.mute();
                          }
                        }
                        function displayLastFrame() {
                          player.seekTo(getLastFrame,false);
                        }
                        function getLastFrame() {
                          player.getPlayerDuration() - 1;
                        }
                        function pauseVideo() {
                          player.pauseVideo();
                        }
                        function resumeCycleSlider() {
                          jQuery('.cycle-slideshow').cycle('resume');
                        }
                      }
                  </script>
              </div>
          <?php endif; ?>
      <?php endforeach; ?>
  </div>
  </div>
</div>
