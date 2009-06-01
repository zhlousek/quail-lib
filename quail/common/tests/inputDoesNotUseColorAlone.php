<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputDoesNotUseColorAlone extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') != 'hidden')
				$this->addReport($input);
		}
	}

}