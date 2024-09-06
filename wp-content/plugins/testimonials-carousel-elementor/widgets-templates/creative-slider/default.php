<?php use Elementor\Icons_Manager;

function get_default_creative_template($settings, $attributes)
{
  if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
    <div <?php echo $attributes; ?>></div>
  <?php } ?>

  <section class="creative">
    <div class="swiper mySwiper mySwiperCreative">
      <div class="swiper-wrapper">
        <?php $counter = 1;
        foreach ($settings['slide'] as $item) {
          $alt = $item['slide_image']['alt'] ?? '' ?>
          <div class="swiper-slide" id="slide-<?php echo esc_attr($counter); ?>">
            <?php if ($item['slide_image']['url']) { ?>
              <img src="<?php echo esc_url($item['slide_image']['url']); ?>"
                   alt="<?php echo esc_attr($alt); ?>">
            <?php } ?>
          </div>
          <?php $counter++;
        } ?>
      </div>
    </div>

    <?php if ($settings['creative_content_enable'] === 'yes') { ?>
      <div class="creative__wrapper-content">
        <?php $counter_content = 1;
        foreach ($settings['slide'] as $item_content) { ?>
          <div class="creative__slide-content <?php if ($counter_content === 1) { ?> active <?php } ?>"
               data-id="slide-<?php echo esc_attr($counter_content); ?>">
            <?php if ($item_content['slide_title_enable'] === 'yes') { ?>
              <div class="creative__slide-title">
                <?php echo wp_kses_post($item_content['slide_title']); ?>
              </div>
            <?php } ?>

            <div class="creative__slide-text">
              <?php echo wp_kses_post($item_content['slide_description']); ?>
            </div>
          </div>
          <?php $counter_content++;
        } ?>
      </div>
    <?php }

    if (
      esc_attr($settings['navigation']) === "dots" || esc_attr($settings['navigation']) === "both"
    ) { ?>
      <div class="swiper-pagination"></div>
    <?php }

    if (
      esc_attr($settings['navigation']) === "both" || esc_attr($settings['navigation']) === "arrows"
    ) { ?>
      <div class="swiper-button-next">
        <?php Icons_Manager::render_icon($settings['icon_scroll_right'], ['aria-hidden' => 'true']) ?>
      </div>
      <div class="swiper-button-prev">
        <?php Icons_Manager::render_icon($settings['icon_scroll_left'], ['aria-hidden' => 'true']) ?>
      </div>
    <?php } ?>
  </section>
<?php } ?>
