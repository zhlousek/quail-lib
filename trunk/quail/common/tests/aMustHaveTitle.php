<?php

class aMustHaveTitle extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}