<?php

class tableUsesCaption extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->firstChild->tagName != 'caption')
				$this->addReport($table);
			
		}
	
	}
}