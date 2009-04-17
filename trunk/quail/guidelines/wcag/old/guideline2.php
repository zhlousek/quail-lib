<?php

class guideline2 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Ensure that all information conveyed with color is also available without color, for example from context or markup..',
			'priority' => 1,
		),
		2 => array(
			'description' => 'Ensure that foreground and background color combinations provide sufficient contrast when viewed by someone having color deficits.',
			'priority' => 3,
			'manual'   => true,
		),
	);
	
	var $guideline = 2;
	
	var $fail_ratio = 4.5;
	
	function checkpoint1() {
		
	}
	
	function checkpoint2() {

		foreach($this->getAllElements(htmlElements::getElementsByOption('non text', false)) as $element) {
			$style = $this->css->getStyle($element);
			if($style['background-color'] && $style['color']) {
				$ratio = colorLuminosity::getLuminosity($style['background'], $style['color']);
				if($ratio < $this->fail_ratio) {
					$this->scored_elements[] = array(
												'element' => $element,
												'pass' => false);
					$result[]['element'] = $element;							
				}
			}
		}
		return $result;
		
	}
}