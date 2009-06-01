<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=145&lang=eng
*/


class aMultimediaTextAlternative extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wmv', 'wav',  'mpg', 'mov', 'ram', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$extension = substr($a->getAttribute('href'), 
							 (strrpos($a->getAttribute('href'), '.') + 1), 4);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}
}