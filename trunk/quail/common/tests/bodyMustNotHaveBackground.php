<?php

class bodyMustNotHaveBackground extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		$body = $this->getAllElements('body');
		if(!$body)
			return false;
		$body = $body[0];
		if($body->hasAttribute('background'))
			$this->addReport(null, null, false);
	}
}