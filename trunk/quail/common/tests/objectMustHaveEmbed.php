<?php

class objectMustHaveEmbed extends quailTest {

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$this->elementHasChild($object, 'embed'))
				$this->addReport($object);
		}
	}
}