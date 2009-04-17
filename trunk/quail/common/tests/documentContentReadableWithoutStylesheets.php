<?php

class documentContentReadableWithoutStylesheets extends quailTest {

	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if($text->hasAttribute('style')) {
				$this->addReport(null, null, false);
				return false;
			}
		}
	
	}
}