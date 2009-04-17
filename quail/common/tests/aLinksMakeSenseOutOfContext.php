<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksMakeSenseOutOfContext extends quailTest {
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(strlen($a->nodeValue) > 1)
				$this->addReport($a);
		}
	}

}