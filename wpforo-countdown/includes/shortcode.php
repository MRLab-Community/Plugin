<?php
function wpcd_countdown_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'duration' => 10, // Durata predefinita
    ), $atts);

    ob_start(); ?>
    <div class="wpcd-countdown-container" data-duration="<?php echo esc_attr($atts['duration']); ?>">
        <div class="wpcd-hidden-content" style="display:none;">
            <?php echo do_shortcode(wp_kses_post($content)); ?>
        </div>
        <button class="wpcd-start-button">Mostra Contenuto</button>
        <div class="wpcd-countdown-display" style="display:none;">
            <div class="wpcd-countdown-timer">
                <svg viewBox="0 0 36 36">
                    <circle class="circle" cx="18" cy="18" r="15"></circle>
                    <text class="time-left" x="36" y="37" text-anchor="middle" dy=".3em"><?php echo esc_attr($atts['duration']); ?></text>
                </svg>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown', 'wpcd_countdown_shortcode');