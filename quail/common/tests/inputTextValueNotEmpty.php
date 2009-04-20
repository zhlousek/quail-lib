<?php

class inputTextValueNotEmpty extends quailTest {
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if(!$input->hasAttribute('value') || trim($input->getAttribute('value')) == '')
					$this->addReport($input);
			
		}
	}
}