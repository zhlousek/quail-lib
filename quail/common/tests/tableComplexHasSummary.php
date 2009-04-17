<?php

class tableComplexHasSummary extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$table->hasAttribute('summary') && $table->firstChild->tagName != 'caption') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}