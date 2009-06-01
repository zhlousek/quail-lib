<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletContainsTextEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('applet') as $applet) {
			if(trim($applet->nodeValue) == '' || !$applet->nodeValue)
				$this->addReport($applet);

		}
	}

}