<?php

class formDeleteIsReversable extends quailTest {
	
	var $watch_words = array('delete', 'remove', 'erase');
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'submit') {
				foreach($this->watch_words as $word) {
					if(strpos(strtolower($input->getAttribute('value')), $word) !== false) 
						$this->addReport($this->getParent($input, 'form', 'body'));
				}				
			}
		}
	}
}