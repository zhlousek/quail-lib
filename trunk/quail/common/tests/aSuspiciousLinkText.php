<?php

class aSuspiciousLinkText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $suspicious = array(
		'click here', 'click', 'more', 'here',
	);

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(in_array(strtolower(trim($a->nodeValue)), $this->suspicious))
				$this->addReport($a);
		}
	
	}
}