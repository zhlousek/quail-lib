<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentHasTitleElement extends quailTest {

	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		if(!$element->item(0))
			$this->addReport(null, null, false);
	
	}
}