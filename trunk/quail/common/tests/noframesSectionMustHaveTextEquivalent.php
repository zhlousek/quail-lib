<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class noframesSectionMustHaveTextEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
			if(!$this->elementHasChild($frameset, 'noframes'))
				$this->addReport($frameset);
		}
		foreach($this->getAllElements('noframes') as $noframes) {
			$this->addReport($noframes);
		}
	}

}