<?php

class guidelineB extends sect508Guideline {

	var $guideline = 'B';
	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements(false, 'media') as $element) {
			$results[]['element'] = $element;
		}
		return $results;
	}

}