<?php

class selectDoesNotChangeContext extends quailTest {

	function check() {
		foreach($this->getAllElements('select') as $select) {
			if($select->hasAttribute('onchange'))
				$this->addReport($select);
		
		}
	}
}