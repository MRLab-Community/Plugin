<?php
/*
Plugin Name: WPForo Countdown
Plugin URI: https://example.com/wpforo-countdown
Description: Aggiunge un conto alla rovescia per nascondere contenuti nei post di WPForo fino a quando non viene attivato dall'utente.
Version: 1.0.0
Author: Il Tuo Nome
Author URI: https://example.com
License: GPL2
*/

// Impedisce l'accesso diretto al file
if (!defined('ABSPATH')) {
    exit;
}

// Definizione delle costanti
define('WPCD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPCD_PLUGIN_URL', plugin_dir_url(__FILE__));

// Registra lo shortcode [countdown]
require_once WPCD_PLUGIN_DIR . 'includes/shortcode.php';

// Enqueue script e stili solo quando necessario
function wpcd_enqueue_scripts() {
    if (is_admin()) {
        // Enqueue script per il pulsante dell'editor
        wp_enqueue_script('wpcd-editor-button', WPCD_PLUGIN_URL . 'assets/wpcd-editor-button.js', ['jquery'], '1.0.0', true);
        wp_localize_script('wpcd-editor-button', 'wpcd_params', [
            'shortcode_tag' => 'countdown',
            'default_duration' => 10, // Durata predefinita
        ]);
    } else {
        // Enqueue CSS e JS per il countdown nel frontend
        wp_enqueue_style('wpcd-countdown-style', WPCD_PLUGIN_URL . 'assets/countdown-style.css', [], '1.0.0');
        wp_enqueue_script('wpcd-countdown-script', WPCD_PLUGIN_URL . 'assets/countdown-script.js', ['jquery'], '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'wpcd_enqueue_scripts');
add_action('wp_enqueue_scripts', 'wpcd_enqueue_scripts');

// Aggiungi il pulsante "Countdown" all'editor di WPForo
function wpcd_add_wpforo_editor_button($settings) {
    $settings['buttons'][] = 'wpcd_countdown_button';
    return $settings;
}
add_filter('wpforo_editor_settings', 'wpcd_add_wpforo_editor_button');

// Aggiunge una nota sull'utilizzo dello shortcode nella pagina di amministrazione
function wpcd_add_admin_menu() {
    add_menu_page(
        'WPForo Countdown',               // Titolo della pagina
        'WPForo Countdown',               // Testo del menu
        'manage_options',                 // Capability
        'wpforo-countdown',               // Slug della pagina
        'wpcd_render_admin_page',         // Funzione di callback
        'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm140.7 256c0 80.2-65.5 145.7-145.7 145.7S65.3 344.2 65.3 264s65.5-145.7 145.7-145.7 145.7 65.5 145.7 145.7zm-140.7-80c-35.3 0-64 28.7-64 64s28.7 64 64 64 64-28.7 64-64-28.7-64-64-64z"/></svg>'), // Icona SVG
        24                                   // Posizione nel menu
    );
}
add_action('admin_menu', 'wpcd_add_admin_menu');

// Renderizza la pagina di amministrazione
function wpcd_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>WPForo Countdown</h1>
        <p>Utilizza il pulsante "Countdown" nell'editor per inserire lo shortcode:</p>
        <pre>[countdown duration="X"]CONTENUTO[/countdown]</pre>
        <ul>
            <li><strong>duration</strong>: Specifica la durata del countdown in secondi (es. 10).</li>
            <li><strong>CONTENUTO</strong>: Può essere un link, un testo o uno shortcode.</li>
        </ul>
    </div>
    <?php
}