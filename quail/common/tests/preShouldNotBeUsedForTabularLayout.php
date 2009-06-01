<?php

class preShouldNotBeUsedForTabularLayout extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('pre') as $pre) {
			$rows = preg_split('/[\n\r]+/', $pre->nodeValue);
			if(count($rows) > 1)
				$this->addReport($pre);
		}
	
	}
}