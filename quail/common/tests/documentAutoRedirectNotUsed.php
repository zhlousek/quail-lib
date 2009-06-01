<?php


class documentAutoRedirectNotUsed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->hasAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}