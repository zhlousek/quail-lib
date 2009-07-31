<?php

class documentContentReadableWithoutStylesheets extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if($text->hasAttribute('style')) {
				$this->addReport(null, null, false);
				return false;
			}
		}
	
	}
}