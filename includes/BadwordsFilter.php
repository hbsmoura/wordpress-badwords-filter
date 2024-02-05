<?php

namespace BadwordsFilter;

use BadwordsFilter\Admin\BadwordsFilterAdmin;
use BadwordsFilter\Public\BadwordsFilterPublic;

class BadwordsFilter {

	public function __construct() {
		
		// Adicionar o código aqui
		$bfAdmin = new BadwordsFilterAdmin();	
		$bfPublic = new BadwordsFilterPublic();	
	}
	
}
