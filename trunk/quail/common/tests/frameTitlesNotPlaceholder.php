<?php

class frameTitlesNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $placeholders = array('title', 'frame', 'frame title', 'the title');
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(in_array(trim($frame->getAttribute('title')), $this->placeholders))
				$this->addReport($frame);
		}
	}

}