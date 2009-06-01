<?php

class documentWordsNotInLanguageAreMarked extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		$body = $this->getAllElements('body');
		$body = $body[0];
		$words = explode(' ', $body->nodeValue);

		if(count($words) > 10)
			$this->addReport(null, null, false);
	}
}