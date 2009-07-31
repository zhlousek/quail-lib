<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class framesHaveATitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;	
	
	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title'))
				$this->addReport($frame);
		}
	}

}