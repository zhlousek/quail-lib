<?php

class inputCheckboxRequiresFieldset extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'checkbox') {
				if(!$this->getParent($input, 'fieldset', 'body'))
					$this->addReport($input);
				
			}
		}
	}
}