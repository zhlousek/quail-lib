<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleIsShort extends quailTest {

	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
		if($title) {
			if(strlen($title->nodeValue)> 150)
				$this->addReport(null, null, false);
		}
	}
}