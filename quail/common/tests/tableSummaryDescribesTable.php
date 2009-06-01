<?php

class tableSummaryDescribesTable extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary'))
				$this->addReport($table);
		}
	}
}