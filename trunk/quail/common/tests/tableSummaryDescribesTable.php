<?php

class tableSummaryDescribesTable extends quailTest {
	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary'))
				$this->addReport($table);
		}
	}
}