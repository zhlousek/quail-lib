<?php

class objectMustHaveEmbed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$this->elementHasChild($object, 'embed'))
				$this->addReport($object);
		}
	}
}