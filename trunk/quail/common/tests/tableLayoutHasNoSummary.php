<?php

class tableLayoutHasNoSummary extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && strlen(trim($table->getAttribute('summary'))) > 1) {
				$first_row = true;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr' && $first_row) {
						if(!$this->elementHasChild($child, 'th'))
							$this->addReport($table);
						$first_row = false;
					}
				}
			}
		}
	
	}
}