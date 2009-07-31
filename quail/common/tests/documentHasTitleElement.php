<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentHasTitleElement extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		if(!$element->item(0))
			$this->addReport(null, null, false);
	
	}
}