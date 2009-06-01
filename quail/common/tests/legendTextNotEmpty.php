<?php

class legendTextNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('legend') as $legend) {
			if(!$legend->nodeValue || trim($legend->nodeValue) == '')
				$this->addReport($legend);
		}
	}
}