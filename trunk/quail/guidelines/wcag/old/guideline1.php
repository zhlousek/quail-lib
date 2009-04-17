<?php

class guideline1 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Provide a text equivalent for every non-text element.',
			'priority' => 1,
		),
		2 => array(
			'description' => 'Provide redundant text links for each active region of a server-side image map.',
			'priority' => 1,
		),
		3 => array(
			'description' => 'Provide an auditory description of the important information of the visual track of a multimedia presentation.', 
			'priority' => 1,
			'manual' => true,
		),
		4 => array( 
			'description' => 'For any time-based multimedia presentation (e.g., a movie or animation), synchronize equivalent alternatives (e.g., captions or auditory descriptions of the visual track) with the presentation.',
			'priority' => 1,
			'manual' => true,
		),
		5 => array( 
			'description' => 'Until user agents render text equivalents for client-side image map links, provide redundant text links for each active region of a client-side image map',
			'priority' => 2,
		),
	);
	
	var $guideline = 1;
	
	function getScore() {
	
	}
	
	function getScoredElements() {
	
	}
	
	function checkpoint1() {

		foreach(htmlElements::getElementsByOption('text', false) as $non_text_tag) {
			
			$elements = $this->getAllElements($non_text_tag);
			
			if($elements) {
				foreach($elements as $non_text) {
					$pass = true;
					if(in_array($non_text_tag, array('img', 'input', 'applet')) && !$non_text->hasAttribute('alt')) 
						$pass = false;
					if(in_array($non_text_tag, array('object, applet')) && 
							(!$non_text->hasAttribute('longdesc') && !$non_text->nodeValue) )
						$pass = false;
					
					if(!$pass) { 
						$result[]['element'] = $non_text;
					}
				}
			}
		}
		return $result;
	}

	function checkpoint2() {
		foreach($this->getAllElements('img') as $element) {
			if($element->hasAttribute('ismap') && !$element->hasAttribute('alt')) 
				$result[]['element'] = $element;
		
		}
		return $result;
	}

	function checkpoint3() {
		
		foreach($this->getAllElements(false, 'media') as $element) {
			$result[]['element'] = $element;
		}
		return $result;
	}

	function checkpoint4() {
		foreach($this->getAllElements(false, 'media') as $element) {
			$result[]['element'] = $element;
		}
		return $result;
	}
	
	function checkpoint5() {
		foreach($this->getAllElements(htmlElements::getElementsByOption('imagemap')) as $element) {
			if(!$element->hasAttribute('alt'))
				$result[]['element'] = $element;
		
		}
		$maps = $this->dom->getElementsByTagName('map');
		if($maps) {
			foreach($maps as $map) {
				foreach($map->childNodes as $node) {
					if(strtolower($node->tagName) == 'a' && !$this->nodeValue)
						$result[]['element'] = $map;
					if(strtolower($node->tagName) == 'area' && 
						(!$node->hasAttribute('alt') || !$node->hasAttribute('longdesc')))
							$result[]['element'] = $node;				
				}
			}
		}
		return $result;
	}

}