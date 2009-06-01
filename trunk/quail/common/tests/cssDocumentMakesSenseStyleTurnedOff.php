<?php

class cssDocumentMakesSenseStyleTurnedOff extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('link') as $link) {
			if($link->parentNode->tagName == 'head') {
				if($link->getAttribute('rel') == 'stylesheet')
					$this->addReport($link);
			}
		}
	}
}