<?php

class guidelineI extends sect508Guideline {

	var $guideline = 'I';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		$frames = $this->getAllElements(array('frame', 'iframe'));
		foreach($frames as $element) {
			if(!$element->hasAttribute('title'))
				$results[]['element'] = $element;
		}
		if(count($frames) > 0 && count($this->getAllElements('noframes')) == 0)
			$results[]['message'] = 'frames-noframes';
		return $results;
	}

}