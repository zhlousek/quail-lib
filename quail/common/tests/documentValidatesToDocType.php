<?php

class documentValidatesToDocType extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		if(!@$this->dom->validate())
			$this->addReport(null, null, false);
	}
}