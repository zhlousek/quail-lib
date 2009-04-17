<?php

class guidelineE extends sect508Guideline {

	var $guideline = 'E';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements('img') as $element) {
			if($element->hasAttribute('ismap'))
				$results[]['element'] = $element;
		}
		return $results;
	}

}