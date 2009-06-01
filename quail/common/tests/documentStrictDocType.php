<?php

class documentStrictDocType extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		if(strpos(strtolower($this->dom->doctype->publicId), 'strict') === false
		   && strpos(strtolower($this->dom->doctype->systemId), 'strict') === false) 
			$this->addReport(null, null, false);
	}
}