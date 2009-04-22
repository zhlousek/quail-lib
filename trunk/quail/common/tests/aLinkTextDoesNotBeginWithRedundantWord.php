<?php

class aLinkTextDoesNotBeginWithRedundantWord extends quailTest {
	
	var $problem_words = array('link to', 'go to');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue) {
				if($a->firstChild->tagName == 'img') {
					$text = $a->firstChild->getAttribute('alt');
				}
			}
			else 
				$text = $a->nodeValue;
			foreach($this->problem_words as $word) {
				if(strpos(trim($text), $word) === 0)
					$this->addReport($a);
			}
		}
	}
}