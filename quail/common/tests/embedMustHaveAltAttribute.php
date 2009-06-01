<?php

class embedMustHaveAltAttribute extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if(!$embed->hasAttribute('alt'))
					$this->addReport($embed);
		
		}
	}
}