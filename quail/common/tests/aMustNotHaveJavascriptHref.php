<?php

class aMustNotHaveJavascriptHref extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(substr(trim($a->getAttribute('href')), 0, 11) == 'javascript:')
				$this->addReport($a);
		}
	}	
}