<?php

class guidelineF extends sect508Guideline {

	var $guideline = 'F';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements('map') as $element) {
			foreach($element->childNodes as $child) {
				if($child->tagName == 'area' && !$child->hasAttribute('alt'))
					$results[]['element'] = $child;
			}
		}
		return $results;
	}

}