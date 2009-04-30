<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIsNotFileName extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' 
				&& strtolower($input->getAttribute('alt')) == strtolower($input->getAttribute('src')))
					$this->addReport($input);
		}
	}

}