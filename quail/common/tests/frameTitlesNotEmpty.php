<?php

class frameTitlesNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title') || trim($frame->getAttribute('title')) == '')
				$this->addReport($frame);
		}
	}
}