<?php

class inputCheckboxRequiresFieldset extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'checkbox') {
				if(!$this->getParent($input, 'fieldset', 'body'))
					$this->addReport($input);
				
			}
		}
	}
}