<?php

class checkboxLabelIsNearby extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'checkbox')
				$this->addReport($input);
			
		}
	}
}