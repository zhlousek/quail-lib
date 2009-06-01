<?php

class aLinksAreSeperatedByPrintableCharacters extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->nextSibling->nextSibling->tagName == 'a' && trim($a->nextSibling->wholeText) == '')
				$this->addReport($a);
		}
	}
}