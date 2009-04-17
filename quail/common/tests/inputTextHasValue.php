<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class inputTextHasValue extends quailTest {
	

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'text' && !$input->hasAttribute('value'))
				$this->addReport($input);	
			
		}
	
	}
}