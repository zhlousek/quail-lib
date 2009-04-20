<?php

class objectWithClassIDHasNoText extends quailTest {

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->nodeValue && $object->hasAttribute('classid'))
				$this->addReport($object);
		
		}
	}
}