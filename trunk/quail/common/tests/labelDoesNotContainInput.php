<?php

class labelDoesNotContainInput extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($this->elementHasChild($label, 'input') || $this->elementHasChild($label, 'textarea'))
				$this->addReport($label);
		}
	}
}