<?php

class guidelineH extends sect508Guideline {

	var $guideline = 'H';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements('table') as $element) {
			if(!$this->elementHasChild($element, 'caption'))
				$resuls[]['element'] = $element;
			
		}
		return $results;
	}

}