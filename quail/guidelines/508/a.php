<?php

class guidelineA extends sect508Guideline {

	var $guideline = 'A';
	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements(null, 'text', false) as $element) {
			if(!$element->hasAttribute('alt'))
				$results[]['element'] = $element;
		
		}
		return $results;
	}

}