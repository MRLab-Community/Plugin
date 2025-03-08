// tinymce-plugins.js

// Verifica se TinyMCE è già caricato
if (typeof tinymce !== 'undefined') {
    // Registra i plugin open source di TinyMCE
    tinymce.PluginManager.requireLangPack('link');
    tinymce.PluginManager.requireLangPack('image');
    tinymce.PluginManager.requireLangPack('codesample'); // Correzione: usiamo codesample
    tinymce.PluginManager.requireLangPack('fullscreen');
    tinymce.PluginManager.requireLangPack('autolink');
    tinymce.PluginManager.requireLangPack('autosave');
    tinymce.PluginManager.requireLangPack('lists');
    tinymce.PluginManager.requireLangPack('charmap');
    tinymce.PluginManager.requireLangPack('hr');
    tinymce.PluginManager.requireLangPack('anchor');
    tinymce.PluginManager.requireLangPack('pagebreak');
    tinymce.PluginManager.requireLangPack('searchreplace');
    tinymce.PluginManager.requireLangPack('wordcount');
    tinymce.PluginManager.requireLangPack('visualblocks');
    tinymce.PluginManager.requireLangPack('visualchars');
    tinymce.PluginManager.requireLangPack('insertdatetime');
    tinymce.PluginManager.requireLangPack('media');
    tinymce.PluginManager.requireLangPack('table');
    tinymce.PluginManager.requireLangPack('help');
}