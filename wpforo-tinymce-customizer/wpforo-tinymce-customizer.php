<?php
/**
 * Plugin Name: WPForo TinyMCE Customizer
 * Description: Personalizza l'editor TinyMCE di WordPress e WPForo con icone simili a Microsoft Word e integra i plugin open source di TinyMCE.
 * Version: 1.4
 * Author: Il tuo nome
 */

// Impedisce l'accesso diretto al file
if (!defined('ABSPATH')) {
    exit;
}

// Aggiungi azioni e filtri necessari
add_action('init', 'wpforo_tinymce_customizer_init');

function wpforo_tinymce_customizer_init() {
    // Modifica le impostazioni globali di TinyMCE
    add_filter('tiny_mce_before_init', 'wpforo_customize_tinymce');
    add_filter('wpforo_editor_settings', 'wpforo_customize_tinymce_for_wpforo');
}

/**
 * Funzione per personalizzare TinyMCE globalmente in WordPress
 */
function wpforo_customize_tinymce($settings) {
    // Definisci i pulsanti e i plugin open source di TinyMCE
    $plugins = array(
        'link', 'image', 'codesample', 'fullscreen', 'autolink', 'autosave', 'lists', 'charmap',
        'hr', 'anchor', 'pagebreak', 'searchreplace', 'wordcount', 'visualblocks', 'visualchars',
        'insertdatetime', 'media', 'table', 'help'
    );

    // Verifica la presenza dei plugin
    $available_plugins = wpforo_check_tinymce_plugins($plugins);

    // Aggiorna le impostazioni
    $settings['toolbar1'] = 'bold,italic,underline,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,link,image,' . ($available_plugins['codesample'] ? 'codesample,' : '') . 'fullscreen';
    $settings['plugins'] = implode(',', $available_plugins);

    // Aggiungi un pulsante personalizzato
    $settings['setup'] = "function(editor) {
        editor.ui.registry.addButton('custom_button', {
            text: 'Personalizzato',
            icon: 'code',
            onAction: function() {
                editor.insertContent('[personalizzato]');
            }
        });
    }";

    // Aggiungi icone personalizzate
    $settings['content_css'] = plugins_url('/css/custom-icons.css', __FILE__);
    $settings['icons'] = 'word_icons';

    return $settings;
}

/**
 * Funzione per personalizzare TinyMCE specificamente in WPForo
 */
function wpforo_customize_tinymce_for_wpforo($settings) {
    // Usa le stesse impostazioni di TinyMCE definite sopra
    return wpforo_customize_tinymce($settings);
}

/**
 * Funzione per controllare la disponibilità dei plugin di TinyMCE
 */
function wpforo_check_tinymce_plugins($plugins) {
    $available_plugins = array();

    foreach ($plugins as $plugin) {
        $plugin_path = ABSPATH . 'wp-includes/js/tinymce/plugins/' . $plugin . '/plugin.min.js';
        if (file_exists($plugin_path)) {
            $available_plugins[] = $plugin;
        }
    }

    return $available_plugins;
}