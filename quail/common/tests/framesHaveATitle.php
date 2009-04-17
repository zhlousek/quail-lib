<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class framesHaveATitle extends quailTest {
	
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title'))
				$this->addReport($frame);
		}
	}

}