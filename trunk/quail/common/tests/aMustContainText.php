<?php

class aMustContainText extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue && !$a->hasAttribute('title')) {
				$fail = true;
				$child = true;
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img' && trim($child->getAttribute('alt')) != '')
						$fail = false;
					if($child->nodeValue)
						$fail = false;
				}
				if($fail)
					$this->addReport($a);
			}
		}
	}
}