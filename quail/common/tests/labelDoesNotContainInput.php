<?php

class labelDoesNotContainInput extends quailTest {

	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($this->elementHasChild($label, 'input'))
				$this->addReport($label);
		}
	}
}