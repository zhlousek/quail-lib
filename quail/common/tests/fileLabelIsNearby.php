<?php

class fileLabelIsNearby extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'file')
				$this->addReport($input);
			
		}
	}
}