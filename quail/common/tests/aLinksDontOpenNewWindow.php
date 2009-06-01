<?php


class aLinksDontOpenNewWindow extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
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