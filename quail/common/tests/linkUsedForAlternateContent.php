<?php

class linkUsedToDescribeNavigation extends quailTest {

	function check() {
		$head = $this->getAllElements('head');
		$head = $head[0];
		foreach($head->childNodes as $child) {
			if($child->tagName == 'link' && $child->getAttribute('rel') != 'stylesheet')
				return true;
		}
		$this->addReport(null, null, false);
	}
}