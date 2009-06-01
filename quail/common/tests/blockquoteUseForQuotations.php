<?php

class blockquoteUseForQuotations extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		$body = $this->getAllelements('body');
		$body = $body[0];
		if(!$body) return false;
		if(strlen($body->nodeValue) > 10)
			$this->addReport(null, null, false);
	
	}

}