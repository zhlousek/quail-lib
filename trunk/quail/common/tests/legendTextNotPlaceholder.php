<?php

class legendTextNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $placeholders = array('&nbsp;', ' ', 'legend');
	
	function check() {
		foreach($this->getAllElements('legend') as $legend) {
			if(in_array(trim($legend->nodeValue), $this->placeholders))
				$this->addReport($legend);
		}
	}

}