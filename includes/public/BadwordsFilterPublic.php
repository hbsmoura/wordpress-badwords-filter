<?php

namespace BadwordsFilter\Public;

class BadwordsFilterPublic {

	public function __construct() {
		add_filter(
			'the_content', [$this, 'filter_function_for_content']
		);

		add_filter(
			'comment_text', [$this, 'filter_function_for_comments']
		);
	}

	public function filter_function($content) {
		if (get_option('badwords_filter_list')) {
            $badWords = explode(',', get_option('badwords_filter_list'));
            $badWords = array_map('trim', $badWords);
            return str_ireplace(
                $badWords,
                esc_html(get_option('badwords_filter_replacement', '!@#$%')),
                $content
            );
        }
        return $content;
	}

	public function filter_function_for_content($content) {
		if (get_option('badwords_filter_enable_for_content')) {
			return $this->filter_function($content);
		}		
		return $content;
	}

	public function filter_function_for_comments($content) {
		if (get_option('badwords_filter_enable_for_comments')) {
			return $this->filter_function($content);
		}		
		return $content;
	}

}
