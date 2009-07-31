<?php

class addressForAuthor extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;


	function check() {
		foreach($this->getAllElements('address') as $address) {
			foreach($address->childNodes as $child) {
				if($child->tagName == 'a')
						return true;
			}
		}
		$this->addReport(null, null, false);
	}

}