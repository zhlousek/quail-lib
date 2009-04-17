<?php

class tableSummaryIsSufficient extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && strlen(trim($table->getAttribute('summary'))) < 11) {
				$this->addReport($table);
			
			
			}
		}
	
	}
}