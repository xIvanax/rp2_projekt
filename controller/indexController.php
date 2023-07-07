<?php

class IndexController {
	public function index() {
		// Samo preusmjeri na login podstranicu.
		header( 'Location: ' . __SITE_URL . '/index.php?rt=hotels/login' );
	}
};

?>
