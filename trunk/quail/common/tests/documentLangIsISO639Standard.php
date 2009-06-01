<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentLangIsISO639Standard extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$languages = file(QUAIL_PATH.'/common/resources/iso639.txt');
		
		$element = $this->dom->getElementsByTagName('html');
		$html = $element->item(0);
		
		if($html->hasAttribute('lang'))
			if(in_array(strtolower($html->getAttribute('lang')), $languages))
				$this->addReport(null, null, false);
	
	}
}