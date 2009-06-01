<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleIsNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$placeholders = file(QUAIL_PATH.'/common/resources/placeholder.txt');		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
		if($title) {
			if(in_array(strtolower($title->nodeValue), $placeholders))
				$this->addReport(null, null, false);
		}
	}
}