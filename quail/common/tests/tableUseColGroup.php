<?php

class tableUseColGroup extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->isData($table)) {
				if(!$this->elementHasChild($table, 'colgroup') && !$this->elementHasChild($table, 'col'))
					$this->addReport($table);
			}
		}
	
	}
}