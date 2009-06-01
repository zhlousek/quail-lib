<?php

class tableSummaryIsSufficient extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && strlen(trim($table->getAttribute('summary'))) < 11) {
				$this->addReport($table);
			
			
			}
		}
	
	}
}