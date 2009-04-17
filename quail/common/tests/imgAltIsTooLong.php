<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIsTooLong extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt') && strlen($img->getAttribute('alt')) > 100) 
				$this->addReport($img);
		}
	
	}
}