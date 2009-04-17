<?php

class guidelineG extends sect508Guideline {

	var $guideline = 'G';

	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements('table') as $element) {
			$has_th = false;
			foreach($element->childNodes as $child) {
				if($child->tagName == 'tr') {
					$row_th = true;
					foreach($child->childNodes as $cells) {
						if($cells->tagName == 'td')
							$row_th = false;
					}
					
					if($row_th)
						$has_th = true;
				}
			
			}
			if(!$has_th)
				$results[]['element'] = $element;
		}
		return $results;
	}

}