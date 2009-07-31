<?php

class documentReadingDirection extends quailTest {


	var $default_severity = QUAIL_TEST_MODERATE;

	var $cms = false;
	
	var $right_to_left = array('he', 'ar');
	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			if(in_array($element->getAttribute('lang'), $this->right_to_left)) {

				if($element->getAttribute('dir') != 'rtl')
				 	$this->addReport($element);
			}
		}			
	}
}