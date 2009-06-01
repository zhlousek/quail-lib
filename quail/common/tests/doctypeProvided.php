<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class doctypeProvided extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		if(!$this->dom->doctype->publicId)
			$this->addReport(null, null, false);		
	}

}