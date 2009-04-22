<?php

class inputImageAltNotRedundant extends quailTest {

	var $problem_words = array('submit', 'button');

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image') {
				foreach($this->problem_words as $word) {
					if(strpos($input->getAttribute('alt'), $word) !== false)
							$this->addReport($input);
				}
			}
		}
	}
}