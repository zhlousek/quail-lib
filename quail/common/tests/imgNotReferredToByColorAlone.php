<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgNotReferredToByColorAlone extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}