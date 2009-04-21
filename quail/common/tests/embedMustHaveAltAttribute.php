<?php

class embedMustHaveAltAttribute extends quailTest {

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if(!$embed->hasAttribute('alt'))
					$this->addReport($embed);
		
		}
	}
}