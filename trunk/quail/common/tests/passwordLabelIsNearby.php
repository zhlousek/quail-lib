<?php

class passwordLabelIsNearby extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'password')
				$this->addReport($input);
			
		}
	}
}