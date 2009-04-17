<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIsSameInText extends quailTest {
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}