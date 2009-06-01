<?php

class tableSummaryIsEmpty extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && trim($table->getAttribute('summary')) == '') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}