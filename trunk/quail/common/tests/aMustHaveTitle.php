<?php

class aMustHaveTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}