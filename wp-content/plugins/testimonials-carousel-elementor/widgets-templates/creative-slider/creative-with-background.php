<?php use Elementor\Icons_Manager;

function get_creative_with_background_template($settings, $attributes)
{
  if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
    <div <?php echo $attributes; ?>></div>
  <?php } ?>

  <section class="creative creative-with-background"
    <?php if ($settings['creative_with_background_image_enable'] === 'yes') { ?>
      style="--creative-with-background: url('<?php echo esc_url($settings['creative_with_background_image_background']['url']); ?>'); "
    <?php } ?>>
    <div class="creative-with-background__wrapper">
      <div class="swiper mySwiper mySwiperCreative">
        <div class="swiper-wrapper">
          <?php $counter = 1;
          foreach ($settings['creative_with_background'] as $item) { ?>
            <div class="swiper-slide" id="slide-<?php echo esc_attr($counter); ?>">
              <?php if ($item['creative_with_background_image']['url']) { ?>
                <img src="<?php echo esc_url($item['creative_with_background_image']['url']); ?>"
                     alt="<?php echo esc_attr($item['creative_with_background_image']['alt']); ?>">
              <?php } ?>
            </div>
            <?php $counter++;
          } ?>
        </div>
      </div>

      <?php if ($settings['creative_with_background_content_enable'] === 'yes') { ?>
        <div class="creative__wrapper-content">
          <?php $counter_content = 1;
          foreach ($settings['creative_with_background'] as $item_content) { ?>
            <div class="creative__slide-content <?php if ($counter_content === 1) { ?> active <?php } ?>"
                 data-id="slide-<?php echo esc_attr($counter_content); ?>">
              <?php if ($item_content['creative_with_background_title_enable'] === 'yes' || $item_content['creative_with_background_subtitle_enable'] === 'yes') { ?>
                <div class="creative__slide-title">
                  <?php echo wp_kses_post($item_content['creative_with_background_title']);

                  if ($item_content['creative_with_background_subtitle_enable'] === 'yes') { ?>
                    <div class="creative__slide-subtitle">
                      <?php echo wp_kses_post($item_content['creative_with_background_subtitle']); ?>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>

              <div class="creative__slide-text">
                <?php echo wp_kses_post($item_content['creative_with_background_description']); ?>
              </div>
            </div>
            <?php $counter_content++;
          } ?>
        </div>
      <?php }

      if (esc_attr($settings['navigation']) !== "none") { ?>
        <div class="creative-with-background__pagination">
          <?php if (
            esc_attr($settings['navigation']) === "dots" || esc_attr($settings['navigation']) === "both"
          ) { ?>
            <div class="swiper-pagination"></div>
          <?php }

          if (
            esc_attr($settings['navigation']) === "both" || esc_attr($settings['navigation']) === "arrows"
          ) { ?>
            <div
                class="swiper-button-next <?php if (esc_attr($settings['navigation']) === "arrows") { ?> creative-with-background__pagination-next <?php } ?>">
              <?php Icons_Manager::render_icon($settings['icon_arrow_right'], ['aria-hidden' => 'true']) ?>
            </div>
            <div
                class="swiper-button-prev <?php if (esc_attr($settings['navigation']) === "arrows") { ?> creative-with-background__pagination-prev <?php } ?>">
              <?php Icons_Manager::render_icon($settings['icon_arrow_left'], ['aria-hidden' => 'true']) ?>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </section>
<?php } ?>
