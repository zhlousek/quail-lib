<?php

class inputImageNotDecorative extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image')
				$this->addReport($input);
		}
	}
}