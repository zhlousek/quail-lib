<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleNotEmpty extends quailTest {

	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
			if(trim($title->nodeValue) == '')
				$this->addReport(null, null, false);
	
	}
}