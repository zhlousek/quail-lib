<?php

class siteMap extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(strtolower(trim($a->nodeValue)) == 'site map')
				return true;
		}
		$this->addReport(null, null, false);
	}
}