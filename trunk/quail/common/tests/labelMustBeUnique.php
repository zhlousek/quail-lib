<?php

class labelMustBeUnique extends quailTest {
	
	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($label->hasAttribute('for'))
				$labels[$label->getAttribute('for')][] = $label;
		}
		foreach($labels as $label) {
			if(count($label) > 1)
				$this->addReport($label[1]);
		}
	}
}