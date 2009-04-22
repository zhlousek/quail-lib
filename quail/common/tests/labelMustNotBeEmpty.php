<?php

class labelMustNotBeEmpty extends quailTest {

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