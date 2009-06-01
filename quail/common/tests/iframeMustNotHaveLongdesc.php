<?php

class iframeMustNotHaveLongdesc extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('iframe') as $iframe) {
			if($iframe->hasAttribute('longdesc'))
				$this->addReport($iframe);
		
		}
	}
}