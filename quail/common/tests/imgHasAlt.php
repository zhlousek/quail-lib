<?php
/**
*   All img elements have an alt attribute.
*
*/
class imgHasAlt extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(!$img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}