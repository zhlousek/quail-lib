<?php

class embedMustNotHaveEmptyAlt extends quailTest {

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if($embed->hasAttribute('alt') && trim($embed->getAttribute('alt')) == '')
					$this->addReport($embed);
		
		}
	}
}