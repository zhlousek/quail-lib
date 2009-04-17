<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=8&lang=eng
*/
class imgHasLongDesc extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('longdesc')) {
				$this->addReport($img);
					
			}
		}
	
	}
}