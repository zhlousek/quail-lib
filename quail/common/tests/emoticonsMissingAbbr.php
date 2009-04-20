<?php

class emoticonsMissingAbbr extends quailTest {

	function check() {
		$emoticons = file(QUAIL_PATH.'/common/resources/emoticons.txt', FILE_IGNORE_NEW_LINES);
		$count = 0;
		foreach($this->getAllElements('abbr') as $abbr) {
			$abbreviated[$abbr->nodeValue] = $abbr->getAttribute('title');
		}
		foreach($this->getAllElements(null, 'text') as $element) {
			if(strlen($element->nodeValue < 2)) {
				$words = explode(' ', $element->nodeValue);
				foreach($words as $word) {
					if(in_array($word, $emoticons)) {
						if(!$abbreviated[$word])
							$this->addReport($element);
					}
				}
			
			}
		}
	
	}
}