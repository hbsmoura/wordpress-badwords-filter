<?php

namespace BadwordsFilter\Admin;

final class BadwordsFilterAdminView {

    private function __construct() {}

    public static function enable_for_content_field_callback() {
		?>
		<label for="badwords_filter_enable_for_content">
			<input
				type="checkbox"
				name="badwords_filter_enable_for_content"
				id="badwords_filter_enable_for_content"
				value="1"
				<?php checked(1, get_option('badwords_filter_enable_for_content'), true) ?>
			><?php esc_html_e('Activate/deactivate for content', 'badwords-filter') ?>
		</label>
		<?php
	}

	public static function enable_for_comments_field_callback() {
		?>
		<label for="badwords_filter_enable_for_comments">
			<input
				type="checkbox"
				name="badwords_filter_enable_for_comments"
				id="badwords_filter_enable_for_comments"
				value="1"
				<?php checked(1, get_option('badwords_filter_enable_for_comments'), true) ?>
			><?php esc_html_e('Activate/deactivate for comments', 'badwords-filter') ?>
		</label>
		<?php
	}

	public static function replacement_field_callback() {
		?>
		<input
			type="text"
			name="badwords_filter_replacement"
			id="badwords_filter_replacement"
			value="<?php echo get_option('badwords_filter_replacement') ?>"
		>
		<?php
	}

	public static function list_field_callback() {
		?>
		<label for="badwords_filter_list">
		<?php esc_html_e(
			'Enter a comma-separated list of words to filter from your content.',
			'badwords-filter'
		) ?>
		<div class="badwords_filter__flex-container">
			<textarea
				name="badwords_filter_list"
				id="badwords_filter_list"
				placeholder="<?php esc_html_e('bad, mean, awful, horrible', 'badwords-filter') ?>"
			><?php echo esc_textarea(get_option('badwords_filter_list')) ?></textarea>
		</div>
		<?php
	}

	public static function settings_page() {
		?>
		<div class="wrap">
            <h1><?php esc_html_e('Badwords Filter Settings', 'badwords-filter') ?></h1>
            <form action="options.php" method="POST">
                <?php
				// Imprime os erros registrados
                settings_errors();
				/**
				 * Entrega os valores de nonce, action e option_page em campos escondidos (hidden)
				 * Serve às configurações da página
				 */
                settings_fields('badwords_filter_admin');

				// Imprime todas as seções de configurações adicionadas a uma página em particular.
                do_settings_sections('badwords_filter_admin');

				// Imprime o botão de submissão
                submit_button();
                ?>
            </form>
        </div>
		<?php
	}
}