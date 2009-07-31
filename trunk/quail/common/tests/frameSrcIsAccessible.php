<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class frameSrcIsAccessible extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $cms = false;
		
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if($frame->hasAttribute('src')) {
				$extension = array_pop(explode('.', $frame->getAttribute('src')));
				if(in_array($extension, $this->image_extensions))
					$this->addReport($frame);
			
			}
		}
	}

}