<?php

class scriptOnclickRequiresOnKeypress extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $click_value = 'onclick';
	
	var $key_value = 'onkeypress';
	
	function check() {
		foreach($this->getAllElements(array_keys(htmlElements::$html_elements)) as $element) {
			if(($element->hasAttribute($this->click_value)) && !$element->hasAttribute($this->key_value))
				$this->addReport($element);
		}
	}

}