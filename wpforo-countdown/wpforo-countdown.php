<?php
/*
Plugin Name: WPForo Countdown Button
Plugin URI: https://example.com/wpforo-countdown-button
Description: Aggiunge un pulsante [countdown-button] per facilitare l'inserimento di uno shortcode [countdown] nei post di WPForo.
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

// Registra gli shortcodes
require_once WPCD_PLUGIN_DIR . 'includes/shortcodes.php';

// Enqueue script e stili solo quando necessario
function wpcd_enqueue_scripts() {
    if (is_admin()) {
        return; // Non caricare nulla nel backend
    }

    // Carica gli stili per il countdown e il pulsante
    wp_enqueue_style('wpcd-countdown-style', WPCD_PLUGIN_URL . 'assets/countdown-style.css', [], '1.0.0');

    // Carica lo script per il popup e il countdown
    wp_enqueue_script('wpcd-countdown-script', WPCD_PLUGIN_URL . 'assets/countdown-script.js', ['jquery'], '1.0.0', true);

    // Localizza i parametri per lo shortcode [countdown]
    wp_localize_script('wpcd-countdown-script', 'wpcd_params', [
        'shortcode_tag' => 'countdown',
        'default_duration' => 10,
    ]);
}
add_action('wp_enqueue_scripts', 'wpcd_enqueue_scripts');

// Aggiunge una nota sull'utilizzo dello shortcode nella pagina di amministrazione
function wpcd_add_admin_menu() {
    add_menu_page(
        'WPForo Countdown Button',         // Titolo della pagina
        'WPForo Countdown Button',         // Testo del menu
        'manage_options',                  // Capability
        'wpforo-countdown-button',         // Slug della pagina
        'wpcd_render_admin_page',          // Funzione di callback
        'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M176 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l16 0 0 34.4C92.3 113.8 16 200 16 304c0 114.9 93.1 208 208 208s208-93.1 208-208c0-41.8-12.3-80.7-33.5-113.2l24.1-24.1c12.5-12.5 12.5-32.8 0-45.3L355.7 50.7c-28.1-23-62.2-38.8-99.7-44.6L256 64l16 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L176 0zM288 204c28.7 0 52 23.3 52 52v96c0 28.7-23.3 52-52 52s-52-23.3-52-52v-96c0-28.7 23.3-52 52-52zm-12 52l0 96c0 6.6 5.4 12 12 12s12-5.4 12-12l0-96c0-6.6-5.6-12.5-12.5-12.5s-12 5.4-12 12z"/></svg>'), // Icona SVG colorata
        24                                   // Posizione nel menu
    );
}
add_action('admin_menu', 'wpcd_add_admin_menu');

// Renderizza la pagina di amministrazione
function wpcd_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>WPForo Countdown Button</h1>
        <p>Utilizza i seguenti shortcodes:</p>
        <pre>[countdown-button]</pre>
        <ul>
            <li>Questo shortcode aggiunge un pulsante "Countdown" nel post.</li>
            <li>Al click sul pulsante, si apre un popup per inserire il contenuto da nascondere.</li>
        </ul>
        <p>Il countdown viene gestito con lo shortcode:</p>
        <pre>[countdown duration="X"]CONTENUTO[/countdown]</pre>
        <ul>
            <li><strong>duration</strong>: Specifica la durata del countdown in secondi (es. 10).</li>
            <li><strong>CONTENUTO</strong>: Può essere un link, un testo o uno shortcode.</li>
        </ul>
    </div>
    <?php
}
