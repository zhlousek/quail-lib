<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgWithMapHasUseMap extends quailTest {
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('ismap') && !$img->hasAttribute('usemap'))
				$this->addReport($img);
		}
	
	}
}