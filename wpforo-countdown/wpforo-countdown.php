<?php
/*
* Plugin Name: <a href="https://mrlab.altervista.org/community" target="_blank">WPForo Countdown</a>
* Description: Aggiunge un conto alla rovescia per nascondere contenuti nei post di WPForo fino a quando non viene attivato dall'utente.
* Author: <a href="https://mrlab.altervista.org/community" target="_blank">MRLab Community</a>
* Version: 1.0
* Text Domain: WPForo Countdown
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
        
        // Enqueue CSS e JS per il countdown nel frontend
        wp_enqueue_style('wpcd-countdown-style', WPCD_PLUGIN_URL . 'assets/countdown-style.css', [], '1.0.0');
        wp_enqueue_script('wpcd-countdown-script', WPCD_PLUGIN_URL . 'assets/countdown-script.js', ['jquery'], '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'wpcd_enqueue_scripts');
add_action('wp_enqueue_scripts', 'wpcd_enqueue_scripts');



// Aggiunge una nota sull'utilizzo dello shortcode nella pagina di amministrazione
function wpcd_add_admin_menu() {
    add_menu_page(
        'WPForo Countdown',               // Titolo della pagina
        'WPForo Countdown',               // Testo del menu
        'manage_options',                 // Capability
        'wpforo-countdown',               // Slug della pagina
        'wpcd_render_admin_page',         // Funzione di callback
        'data:image/svg+xml;base64,' . base64_encode('<svg style="fill: var(--fa-primary-color, currentcolor)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160l0 96 192 0 160 0 8.2 0c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7l0-32.7c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zM320 352l-96 0c-17.7 0-32-14.3-32-32l0-32L0 288 0 416c0 35.3 28.7 64 64 64l296.2 0C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zM496 288c8.8 0 16 7.2 16 16l0 48 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-48 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16z"/></svg>'), // Icona SVG corretta
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