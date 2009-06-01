<?php

class objectWithClassIDHasNoText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->nodeValue && $object->hasAttribute('classid'))
				$this->addReport($object);
		
		}
	}
}