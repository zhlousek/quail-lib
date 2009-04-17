<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class noframesSectionMustHaveTextEquivalent extends quailTest {
	
	
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