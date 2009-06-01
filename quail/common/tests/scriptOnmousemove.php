<?php

class scriptOnmousemove extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $click_value = 'onmousemove';
	
	var $key_value = 'onkeypress';
	
	function check() {
		foreach($this->getAllElements(array_keys(htmlElements::$html_elements)) as $element) {
			if(($element->hasAttribute($this->click_value)))
				$this->addReport($element);
		}
	}

}