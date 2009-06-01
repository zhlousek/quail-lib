<?php

class listNotUsedForFormatting extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements(array('ul', 'ol')) as $list) {
			$li_count = 0;
			foreach($list->childNodes as $child) {
				if($child->tagName == 'li')
					$li_count++;
			}
			if($li_count < 2)
				$this->addReport($list);
		}
	
	}
}