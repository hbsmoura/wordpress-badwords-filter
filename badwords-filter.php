<?php

/**
 *
 * Plugin Name:       Badwords Filter
 * Description:       Plugin para filtragem de palavras indesejadas no conteúdo das postagens
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP: 	  7.0
 * Author:            hbsmoura
 * Author URI:        https://github.com/hbsmoura
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       badwords-filter
 * Domain Path:       /languages
 */

// Aborta quando chamado diretamente.
if (!defined('ABSPATH')) exit;

// Define as constantes do plugin
define('BADWORDS_FILTER_PATH', plugin_dir_path(__FILE__));
define('BADWORDS_FILTER_URL', plugin_dir_url(__FILE__));
define('BADWORDS_FILTER_BASENAME', plugin_basename(__FILE__));
define('BADWORDS_FILTER_VERSION', get_file_data(__FILE__, ['Version'], 'plugin'));

load_plugin_textdomain('badwords-filter', false, dirname(BADWORDS_FILTER_BASENAME) . '/languages');

// Registra as funções para os hooks de ativação e desativação do plugin
register_activation_hook(__FILE__, 'badwords_filter_activate');
register_deactivation_hook(__FILE__, 'badwords_filter_deactivate');

function badwords_filter_activate() {
    $options = [
        'badwords_filter_enable_for_content',
        'badwords_filter_enable_for_comments',
        'badwords_filter_replacement',
        'badwords_filter_list'
    ];

    foreach($options as $option) {
        if(!get_option($option)) add_option($option);
    }

    update_option('badwords_filter_enable_for_content', 1);
    update_option('badwords_filter_enable_for_comments', 1);

    if (!get_option('badwords_filter_replacement')) {
        update_option('badwords_filter_replacement', '!@#$%');
    }
}

function badwords_filter_deactivate() {
    update_option('badwords_filter_enable_for_content', '');
    update_option('badwords_filter_enable_for_comments', '');
}

// Chama o autoloader.php
require_once BADWORDS_FILTER_PATH . 'autoloader.php';

// Cria o objeto principal
// O root namespace deve ser alterado no autoloader para funcionar adequadamente
$plugin = new BadwordsFilter\BadwordsFilter();
