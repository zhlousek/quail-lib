<?php

class aLinksAreSeperatedByPrintableCharacters extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->nextSibling->nextSibling->tagName == 'a' && trim($a->nextSibling->wholeText) == '')
				$this->addReport($a);
		}
	}
}