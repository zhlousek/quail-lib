<?php

class bodyMustNotHaveBackground extends quailTest {

	function check() {
		$body = $this->getAllElements('body');
		if(!$body)
			return false;
		$body = $body[0];
		if($body->hasAttribute('background'))
			$this->addReport(null, null, false);
	}
}