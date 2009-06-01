<?php

class pNotUsedAsHeader extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $head_tags = array('strong', 'span', 'em', 'font', 'i', 'b', 'u');
	
	function check() {
		foreach($this->getAllElements('p') as $p) {
			if(($p->nodeValue == $p->firstChild->nodeValue)
				&& in_array($p->firstChild->tagName, $this->head_tags))
				$this->addReport($p);
		}
	}
}