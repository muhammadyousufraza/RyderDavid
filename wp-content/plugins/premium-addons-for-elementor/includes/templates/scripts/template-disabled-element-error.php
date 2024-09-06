<?php
/**
 * Templates Loader Error
 */
?>

<div class="elementor-library-error">
	<div class="elementor-library-error-message">
        <span>
            <?php esc_html_e('This template requires', 'premium-addons-for-elementor' ) ; ?>
            <a class='elementor-library-enable-element' href="{{ widgetURL }}" target='_blank'>{{{ name }}}</a></span>
            <?php esc_html_e('widget to be enabled. Enable it from ', 'premium-addons-for-elementor' ) ; ?>
            <a class='elementor-library-enable-element' href="{{ url }}" target='_blank'>here</a><?php esc_html_e(', refresh this page and try to insert the template again.', 'premium-addons-for-elementor' ) ; ?>
        </span>
	</div>
</div>
