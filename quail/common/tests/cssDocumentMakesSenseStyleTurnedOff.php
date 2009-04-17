<?php

class cssDocumentMakesSenseStyleTurnedOff extends quailTest {

	function check() {
		foreach($this->getAllElements('link') as $link) {
			if($link->parentNode->tagName == 'head') {
				if($link->getAttribute('rel') == 'stylesheet')
					$this->addReport($link);
			}
		}
	}
}