<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksDontOpenNewWindow extends quailTest {
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('target') 
				&& !in_array($a->getAttribute('target'), $this->allowed_targets)) {
					$this->addReport($a);
			}
		}
	}

}