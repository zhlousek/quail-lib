<?php

class scriptInBodyMustHaveNoscript extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('script') as $script) {
			if($script->nextSibling->tagName != 'noscript' 
				&& $script->parentNode->tagName != 'head')
					$this->addReport($script);
		
		}
	}

}