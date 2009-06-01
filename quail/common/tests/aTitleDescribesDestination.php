<?php

class aTitleDescribesDestination extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}