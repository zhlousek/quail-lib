<?php

/**
*	Checks that all color and background elements has stufficient contrast.
*
*/
class cssTextHasContrast extends quailColorTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			$style = $this->css->getStyle($element);
			if(($style['background'] || $style['background-color']) && $style['color']) {
				$background = ($style['background'])
							   ? $style['background-color']
							   : $style['background'];
				$luminosity = $this->getLuminosity(
								trim($background, '#'), 
								trim($style['color'], '#'));
				if($luminosity < 5) {
					$this->addReport($element, null, false);
				}
			}
		}	
		
	}

}