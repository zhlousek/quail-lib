<?php

class blockquoteUseForQuotations extends quailTest {

	function check() {
		$body = $this->getAllelements('body');
		$body = $body[0];
		if(!$body) return false;
		if(strlen($body->nodeValue) > 10)
			$this->addReport(null, null, false);
	
	}

}