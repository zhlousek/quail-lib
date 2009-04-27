<?php

class inputElementsDontHaveAlt extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') != 'image' && $input->hasAttribute('alt'))
				$this->addReport($input);
		}
	}
}