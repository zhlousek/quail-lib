<?php

class tableComplexHasSummary extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$table->hasAttribute('summary') && $table->firstChild->tagName != 'caption') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}