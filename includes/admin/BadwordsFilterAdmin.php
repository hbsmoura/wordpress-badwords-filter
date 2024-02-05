<?php

namespace BadwordsFilter\Admin;

class BadwordsFilterAdmin {

	protected $view = BadwordsFilterAdminView::class;

	public function __construct() {
		
		add_action('admin_menu', [$this, 'add_submenu']);
		add_action('admin_init', [$this, 'register_settings']);
	}

	public function add_menu() {
		/**
		 * Adiciona uma tag no menu principal do admin
		 * Essa tag redireciona para uma página específica
		 */ 
		$hookSuffix = add_menu_page(
			esc_html__('Badwords Filter Settings', 'badwords-filter'),
			esc_html__('Badwords Filter', 'badwords-filter'),
			'manage_options',
			'badwords_filter_admin',
			[$this->view, 'settings_page'],			
			'dashicons-filter' // Também aceita arquivo svg e xml em base64
		);
	}

	public function add_submenu() {
		/**
		 * Adiciona uma tag à opção de submenu selecionado (parent-slug)
		 * Essa tag redireciona para uma página específica
		 * As opções de submenu podem ser acessadas via função predefinida ou slug específico:
		 * - add_dashboard_page() – index.php
		 * - add_posts_page() – edit.php
		 * - add_media_page() – upload.php
		 * - add_pages_page() – edit.php?post_type=page
		 * - add_comments_page() – edit-comments.php
		 * - add_theme_page() – themes.php
		 * - add_plugins_page() – plugins.php
		 * - add_users_page() – users.php
		 * - add_management_page() – tools.php
		 * - add_options_page() – options-general.php
		 * - add_options_page() – settings.php
		 * - add_links_page() – link-manager.php – requires a plugin since WP 3.5+
		 * - Custom Post Type – edit.php?post_type=wporg_post_type
		 * - Network Admin – settings.php
		 */
		$hookSuffix = add_submenu_page(
			'tools.php',
			esc_html__('Badwords Filter Settings', 'badwords-filter'),
			esc_html__('Badwords Filter', 'badwords-filter'),
			'manage_options',
			'badwords_filter_admin',
			[$this->view, 'settings_page']
		);

		add_action('load-' . $hookSuffix, function() {
			wp_enqueue_style(
				'badwords_filter_admin_style',
				BADWORDS_FILTER_URL . 'includes/admin/css/style.css'
			);
		});
	}

	public function register_settings() {
		add_settings_section(
			'badwords_filter_main_section', // String identificadora para a seção
			'', // Título que vai aparecer na página (frontend)
			null, // Callback da seção, a ser posicionado abaixo do título
			'badwords_filter_admin' // Página a que pertence a seção
		);

		add_settings_field(
			'badwords_filter_enable_for_content', // String identificadora para o campo
			esc_html__('Enable for content', 'badwords-filter'), // Etiqueta que vai aparecer na página (frontend)
			[$this->view, 'enable_for_content_field_callback'], // Callback do campo, a ser posicionado ao lado da etiqueta
			'badwords_filter_admin', // Página a que pertence o campo
			'badwords_filter_main_section', // Seção a que pertence o campo
		);

		add_settings_field(
			'badwords_filter_enable_for_comments', // String identificadora para o campo
			esc_html__('Enable for comments', 'badwords-filter'), // Etiqueta que vai aparecer na página (frontend)
			[$this->view, 'enable_for_comments_field_callback'], // Callback do campo, a ser posicionado ao lado da etiqueta
			'badwords_filter_admin', // Página a que pertence o campo
			'badwords_filter_main_section', // Seção a que pertence o campo
		);

		add_settings_field(
			'badwords_filter_replacement', // String identificadora para o campo
			esc_html__('Replacement characters', 'badwords-filter'), // Etiqueta que vai aparecer na página (frontend)
			[$this->view, 'replacement_field_callback'], // Callback do campo, a ser posicionado ao lado da etiqueta
			'badwords_filter_admin', // Página a que pertence o campo
			'badwords_filter_main_section' // Seção a que pertence o campo
		);

		add_settings_field(
			'badwords_filter_list', // String identificadora para o campo
			esc_html__('List of words', 'badwords-filter'), // Etiqueta que vai aparecer na página (frontend)
			[$this->view, 'list_field_callback'], // Callback do campo, a ser posicionado ao lado da etiqueta
			'badwords_filter_admin', // Página a que pertence o campo
			'badwords_filter_main_section' // Seção a que pertence o campo
		);

		// Veja: https://wp-kama.com/function/register_setting
		register_setting(
			/**
			 * $option_group
			 * Nome do grupo (Página) ao qual a opção pertencerá.
			 * Esse nome deve bater com o nome do grupo em settings_fields()
			 */
			'badwords_filter_admin',
			/**
			 * $option_name
			 * Nome da opção a ser salva no banco de dados, na tabela {$wpdb->prefix}_options
			 */
			'badwords_filter_enable_for_content'
		);

		register_setting(
			'badwords_filter_admin',
			'badwords_filter_enable_for_comments'
		);

		register_setting(
			'badwords_filter_admin',
			'badwords_filter_replacement',
			function($input) {
				return sanitize_text_field($input);
			}
		);
		register_setting(
			'badwords_filter_admin',
			'badwords_filter_list',
			function($input) {
				return sanitize_textarea_field($input);
			}
		);
	}	
}
