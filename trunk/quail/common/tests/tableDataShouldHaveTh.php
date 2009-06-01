<?php

class tableDataShouldHaveTh extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->isData($table))
				$this->addReport($table);
		
		}
	
	}

}