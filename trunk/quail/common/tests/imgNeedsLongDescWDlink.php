<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=9
*/
class imgNeedsLongDescWDlink extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('longdesc')) {
				$next = $this->getNextElement($img);
				
				if($next->tagName != 'a') 
					$this->addReport($img);
				else {
					
					if(((strtolower($next->nodeValue) != '[d]' && strtolower($next->nodeValue) != 'd') )
						|| $next->getAttribute('href') != $img->getAttribute('longdesc')) {
							$this->addReport($img);
					}
				}
					
			}
		}
	
	}
}