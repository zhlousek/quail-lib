<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIdentifiesLinkDestination extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue) {
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img' && $child->hasAttribute('alt'))
						$this->addReport($child);
				}
			}
		}
	
	}
}