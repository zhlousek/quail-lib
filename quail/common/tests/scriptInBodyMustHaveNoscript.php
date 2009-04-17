<?php

class scriptInBodyMustHaveNoscript extends quailTest {

	function check() {
		foreach($this->getAllElements('script') as $script) {
			if($script->nextSibling->tagName != 'noscript' 
				&& $script->parentNode->tagName != 'head')
					$this->addReport($script);
		
		}
	}

}