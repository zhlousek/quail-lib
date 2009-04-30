<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=7&lang=eng
*/
class imgAltNotEmptyInAnchor extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue && $a->childNodes) {
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img'
						&& trim($child->getAttribute('alt')) == '')
							$this->addReport($child);
				}
			}
		}
	
	}
}