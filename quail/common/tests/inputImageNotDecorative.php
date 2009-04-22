<?php

class inputImageNotDecorative extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image')
				$this->addReport($input);
		}
	}
}