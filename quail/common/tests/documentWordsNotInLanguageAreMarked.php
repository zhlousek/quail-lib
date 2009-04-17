<?php

class documentWordsNotInLanguageAreMarked extends quailTest {

	function check() {
		$body = $this->getAllElements('body');
		$body = $body[0];
		$words = explode(' ', $body->nodeValue);

		if(count($words) > 10)
			$this->addReport(null, null, false);
	}
}