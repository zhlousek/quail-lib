<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageHasAlt extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' 
					&& (trim($input->getAttribute('alt')) == '' || !$input->hasAttribute('alt')))
				$this->addReport($input);
		}
	}

}