<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class imgAltEmptyForDecorativeImages extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	}

}