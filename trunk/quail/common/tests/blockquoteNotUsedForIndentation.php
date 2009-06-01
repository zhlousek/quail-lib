<?php

class blockquoteNotUsedForIndentation extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('blockquote') as $blockquote) {
			if(!$blockquote->hasAttribute('cite'))
				$this->addReport($blockquote);
		}
	}
}