<?php

class menuNotUsedToFormatText extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('menu') as $menu) {
			$list_items = 0;
			foreach($menu->childNodes as $child) {
				if($child->tagName == 'li')
					$list_items++;
			}
			if($list_items == 1)
				$this->addReport($menu);
		}
	
	}
}