<?php
/**
 * Gestione degli shortcodes [countdown-button] e [countdown].
 */

// Shortcode per il pulsante di countdown
function wpcd_countdown_button_shortcode($atts) {
    ob_start(); ?>
    <button class="wpcd-countdown-trigger">
        <span class="wpcd-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M176 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l16 0 0 34.4C92.3 113.8 16 200 16 304c0 114.9 93.1 208 208 208s208-93.1 208-208c0-41.8-12.3-80.7-33.5-113.2l24.1-24.1c12.5-12.5 12.5-32.8 0-45.3L355.7 50.7c-28.1-23-62.2-38.8-99.7-44.6L256 64l16 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L176 0zM288 204c28.7 0 52 23.3 52 52v96c0 28.7-23.3 52-52 52s-52-23.3-52-52v-96c0-28.7 23.3-52 52-52zm-12 52l0 96c0 6.6 5.4 12 12 12s12-5.4 12-12l0-96c0-6.6-5.6-12.5-12.5-12.5s-12 5.4-12 12z"/></svg>
        </span>
        Inserisci Contenuto
    </button>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown-button', 'wpcd_countdown_button_shortcode');

// Shortcode per il countdown
function wpcd_countdown_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'duration' => 10, // Durata predefinita
    ], $atts);

    if (empty($content)) {
        return '<p>Errore: Specifica il contenuto da nascondere.</p>';
    }

    ob_start(); ?>
    <div class="wpcd-countdown-container" data-duration="<?php echo esc_attr($atts['duration']); ?>" style="display:none;">
        <div class="wpcd-hidden-content" style="display:none;">
            <?php echo do_shortcode(wp_kses_post($content)); ?>
        </div>
        <button class="wpcd-start-button">Mostra Contenuto</button>
        <div class="wpcd-countdown-display" style="display:none;">
            <div class="wpcd-countdown-timer">
                <svg viewBox="0 0 36 36">
                    <circle class="circle" cx="19" cy="19" r="16"></circle>
                    <text class="time-left" x="37" y="33" text-anchor="middle" dy=".3em"><?php echo esc_attr($atts['duration']); ?></text>
                </svg>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown', 'wpcd_countdown_shortcode');
