<?php

class aImgAltNotRepetative extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;


	function check() {
		foreach($this->getAllElements('a') as $a) {
			foreach($a->childNodes as $child) {
				if($child->tagName == 'img') {
					if(trim($a->nodeValue) == trim($child->getAttribute('alt')))
						$this->addReport($child);
				}
			}
		}
	}
}