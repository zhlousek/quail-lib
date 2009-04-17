<?php

class guideline4 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Clearly identify changes in the natural language of a document\'s text and any  text equivalents (e.g., captions).',
			'priority' => 1,
			'manual' 	 => true,
		),
		2 => array(
			'description' => 'Specify the expansion of each abbreviation or acronym in a document where it first occurs.',
			'priority' => 3,
			'manual' => true,
		),
		3 => array(
			'description' => 'Identify the primary natural language of a document.',
			'priority' => 3,
		),
	);
	
	var $guideline = 4;
	
	function checkpoint1() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if(mb_detect_encoding($text->nodeValue) !== 'ASCII' && !$text->hasAttribute('lang'))
				$result[]['element'] = $text;
		}
		return $result;		
	}
	
	function checkpoint2() {
		$abbr_tags = htmlElements::getElementsByOption('acronym'); 
		foreach($this->getAllElements(null, 'text') as $text) {
			$check_abbr = false;
			foreach($text->childNodes as $child) {
				if(in_array($child->tagName, $abbr_tags) && $child->hasAttribute('title')) {
					$check_abbr = true;
					$predefined[strtoupper($child->nodeValue)] = true;
				}
			}
			if(!$check_abbr) {
				$words = explode(' ', $text->nodeValue);
				if(count($words) > 1 && strtoupper($text->nodeValue) != $text->nodeValue) {
					foreach($words as $word) {
						if(strtoupper($word) == $word && strlen($word) > 1 && !$predefined[$word])
							$result[]['message'] = 'The acronym '. $word .' must be defined';
					}
				}
			}
		}
		return $result;
	}
	
	function checkpoint3() {
		$htmls = $this->getAllElements('html');
		foreach($htmls as $html) {
			if(!$html->hasAttribute('lang'))
				$result[]['message'] = 'You must defined the primary language for this page.';
		}
		return $result;
	}
}