<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class frameRelationshipsMustBeDescribed extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
		
			if(!$frameset->hasAttribute('longdesc') && $frameset->childNodes->length > 2)
				$this->addReport($frameset);
		}
	}

}