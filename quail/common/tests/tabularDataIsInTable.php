<?php

class tabularDataIsInTable extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if(strpos($text->nodeValue, "\t") !== false || $text->tagName == 'pre')
				$this->addReport($text);
		}
	}
}