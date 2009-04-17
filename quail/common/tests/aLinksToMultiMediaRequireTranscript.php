<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksToMultiMediaRequireTranscript extends quailTest {
	
	var $extensions = array('wmv', 'mpg', 'mov', 'ram', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$filename = explode('.', $a->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}

}