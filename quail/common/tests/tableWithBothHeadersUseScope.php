<?php

class tableWithBothHeadersUseScope extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			$fail = false;
			foreach($table->childNodes as $child) {
				if($child->tagName == 'tr') {
					if($child->firstChild->tagName == 'td') {
						if(!$child->firstChild->hasAttribute('scope'))
							$fail = true;
					}
					else {
						foreach($child->childNodes as $td) {
							if($td->tagName == 'th' && !$td->hasAttribute('scope'))
								$fail = true;
						}
					}
				}
			}
			if($fail)
				$this->addReport($table);
		}
	}
}