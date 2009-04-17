<?php

class documentAbbrIsUsed extends quailTest {
	
	var $acronym_tag = 'abbr';
	
	function check() {
		foreach($this->getAllElements($this->acronym_tag) as $acronym) {
			$predefined[trim($acronym->nodeValue)] = $acronym->getAttribute('title');
		}
		foreach($this->getAllElements(null, 'text') as $text) {

			$words = explode(' ', $text->nodeValue);
			if(count($words) > 1 && strtoupper($text->nodeValue) != $text->nodeValue) {
				foreach($words as $word) {
					$word = preg_replace("/[^a-zA-Z0-9s]/", "", $word);
					if(strtoupper($word) == $word && strlen($word) > 1 && !$predefined[$word])
						$this->addReport($text);
				}
			}
		}
		
	}

}