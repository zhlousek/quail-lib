<?php

class aTitleDescribesDestination extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}