<?php

class objectMustHaveTitle extends quailTest {

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->hasAttribute('title'))
				$this->addReport($object);
			
		}
	}

}