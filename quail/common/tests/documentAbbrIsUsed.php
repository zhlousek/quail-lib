<?php

class documentAbbrIsUsed extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $acronym_tag = 'abbr';
	
	function check() {
		foreach($this->getAllElements($this->acronym_tag) as $acronym) {
			$predefined[strtoupper(trim($acronym->nodeValue))] = $acronym->getAttribute('title');
		}
		$already_reported = array();
		foreach($this->getAllElements(null, 'text') as $text) {

			$words = explode(' ', $text->nodeValue);
			if(count($words) > 1 && strtoupper($text->nodeValue) != $text->nodeValue) {
				foreach($words as $word) {
					$word = preg_replace("/[^a-zA-Zs]/", "", $word);
					if(strtoupper($word) == $word && strlen($word) > 1 && !$predefined[strtoupper($word)])

						if(!$already_reported[strtoupper($word)]) {
							$this->addReport($text, 'Word "'. $word .'" requires an <code>'. $this->acronym_tag .'</code> tag.');
						}
						$already_reported[strtoupper($word)] = true;
				}
			}
		}
		
	}

}