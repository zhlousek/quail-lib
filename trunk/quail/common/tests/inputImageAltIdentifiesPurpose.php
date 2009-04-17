<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIdentifiesPurpose extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image')
				$this->addReport($input);
		}
	}

}