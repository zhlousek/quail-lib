<?php

class imgWithMathShouldHaveMathEquivalent extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(($img->getAttribute('width') > 100 
				|| $img->getAttribute('height') > 100 )
				&& $img->nextSibling->tagName != 'math')
					$this->addReport($img);
		
		}
	}
}