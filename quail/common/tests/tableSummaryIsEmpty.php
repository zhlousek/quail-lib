<?php

class tableSummaryIsEmpty extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && trim($table->getAttribute('summary')) == '') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}