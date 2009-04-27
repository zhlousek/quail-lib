<?php

class documentValidatesToDocType extends quailTest {

	function check() {
		if(!@$this->dom->validate())
			$this->addReport(null, null, false);
	}
}