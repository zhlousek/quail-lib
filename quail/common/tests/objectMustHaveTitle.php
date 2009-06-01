<?php

class objectMustHaveTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->hasAttribute('title'))
				$this->addReport($object);
			
		}
	}

}