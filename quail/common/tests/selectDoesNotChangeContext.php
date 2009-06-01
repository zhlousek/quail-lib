<?php

class selectDoesNotChangeContext extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('select') as $select) {
			if($select->hasAttribute('onchange'))
				$this->addReport($select);
		
		}
	}
}