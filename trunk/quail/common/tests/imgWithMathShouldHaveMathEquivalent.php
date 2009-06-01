<?php

class imgWithMathShouldHaveMathEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(($img->getAttribute('width') > 100 
				|| $img->getAttribute('height') > 100 )
				&& $img->nextSibling->tagName != 'math')
					$this->addReport($img);
		
		}
	}
}