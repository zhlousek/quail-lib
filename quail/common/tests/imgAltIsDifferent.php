<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class imgAltIsDifferent extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(trim($img->getAttribute('src')) == trim($img->getAttribute('alt')))
				$this->addReport($img);
		}
	}

}