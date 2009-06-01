<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=8&lang=eng
*/
class imgHasLongDesc extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('longdesc')) {
				$this->addReport($img);
					
			}
		}
	
	}
}