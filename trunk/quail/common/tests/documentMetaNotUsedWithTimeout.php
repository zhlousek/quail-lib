<?php


class documentMetaNotUsedWithTimeout extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->getAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}