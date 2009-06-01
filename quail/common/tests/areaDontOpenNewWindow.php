<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaDontOpenNewWindow extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('area') as $area) {
			if($area->hasAttribute('target') 
				&& !in_array($area->getAttribute('target'), $this->allowed_targets)) {
					$this->addReport($area);
			}
		}
	}

}