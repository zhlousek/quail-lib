<?php


class linkUsedToDescribeNavigation extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$head = $this->getAllElements('head');
		$head = $head[0];
		if($head->childNodes) {
			foreach($head->childNodes as $child) {
				if($child->tagName == 'link' && $child->getAttribute('rel') != 'stylesheet')
					return true;
			}
			$this->addReport(null, null, false);
		}
	}
}