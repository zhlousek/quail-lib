<?php

class inputElementsDontHaveAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') != 'image' && $input->hasAttribute('alt'))
				$this->addReport($input);
		}
	}
}