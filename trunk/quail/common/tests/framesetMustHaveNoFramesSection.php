<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class framesetMustHaveNoFramesSection extends quailTest {
	
	
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
			if(!$this->elementHasChild($frameset, 'noframes'))
				$this->addReport($frameset);
		}
	}

}