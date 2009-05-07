<?php

class radioLabelIsNearby extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'radio')
				$this->addReport($input);
			
		}
	}
}