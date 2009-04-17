<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIsShort extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' && strlen($input->getAttribute('alt')) > 100)
				$this->addReport($input);
		}
	}

}