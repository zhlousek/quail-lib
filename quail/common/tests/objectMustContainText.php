<?php

class objectMustContainText extends quailTest {

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->nodeValue || trim($object->nodeValue) == '')
				$this->addReport($object);
		
		}
	}
}