<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletContainsTextEquivalentInAlt extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	
	function check() {
		foreach($this->getAllElements('applet') as $applet) {
			if(!$applet->hasAttribute('alt') || $applet->getAttribute('alt') == '')
				$this->addReport($applet);

		}
	}

}