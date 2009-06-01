<?php

class labelMustNotBeEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('label') as $label) {
			if(trim($label->nodeValue) == '') {
				$fail = true;
				foreach($label->childNodes as $child) {
					if($child->tagName == 'img' && trim($child->getAttribute('alt')) != '')
						$fail = false;
				}
				if($fail)
					$this->addReport($label);
				
			}
		}
	}
}