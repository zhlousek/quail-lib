<?php

class guidelineC extends sect508Guideline {

	var $guideline = 'C';

	var $fail_ratio = 4.5;	
	
	/**
	*	A text equivalent for every non-text element shall be provided.
	*
	*/
	function check() {
		$results = array();
		foreach($this->getAllElements(false, 'text') as $element) {
			$style = $this->css->getStyle($element);
			if($style['background-color'] && $style['color']) {
				$ratio = colorLuminosity::getLuminosity($style['background'], $style['color']);
				if($ratio < $this->fail_ratio) 
					$results[]['element'] = $element;							
				
			}
		}
		return $results;
	}

}