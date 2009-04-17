<?php

class guidelineD extends sect508Guideline {

	var $guideline = 'D';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		if(!$this->hasHeaders())
			$results[]['message'] = 'no-headers';
		foreach($this->getAllElements(false, 'header') as $element) {
			$image = false;
			foreach($element->childNodes as $child) {
				if($child->tagName == 'img')
					$image = true;
			}
			if($image && !$element->nodeValue)
				$results[]['element'] = $element;
		}
		return $results;
	}
	
	function hasHeaders() {
		if(count($this->getAllElements(false, 'header')) == 0)
			return false;
		return true;
	}

}