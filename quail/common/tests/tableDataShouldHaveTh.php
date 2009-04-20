<?php

class tableDataShouldHaveTh extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->isData($table))
				$this->addReport($table);
		
		}
	
	}

}