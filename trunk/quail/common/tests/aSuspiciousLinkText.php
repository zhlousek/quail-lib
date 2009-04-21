<?php

class aSuspiciousLinkText extends quailTest {

	var $suspicious = array(
		'click here', 'click', 'more'
	);

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(in_array(trim($a->nodeValue), $this->suspicious))
				$this->addReport($a);
		}
	
	}
}