<?php

class objectMustContainText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->nodeValue || trim($object->nodeValue) == '')
				$this->addReport($object);
		
		}
	}
}