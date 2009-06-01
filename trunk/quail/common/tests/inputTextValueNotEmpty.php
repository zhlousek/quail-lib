<?php

class inputTextValueNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if(!$input->hasAttribute('value') || trim($input->getAttribute('value')) == '')
					$this->addReport($input);
			
		}
	}
}