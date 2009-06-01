<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class imgAltIsDifferent extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(trim($img->getAttribute('src')) == trim($img->getAttribute('alt')))
				$this->addReport($img);
		}
	}

}