<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=4&lang=eng
*/
class imgNonDecorativeHasAlt extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('src') && 
				($img->hasAttribute('alt') && html_entity_decode((trim($img->getAttribute('alt')))) == '')) {
				$this->addReport($img);
				
			}
		}
	
	}
}