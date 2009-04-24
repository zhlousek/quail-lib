<?php

class documentStrictDocType extends quailTest {

	function check() {
		if(strpos(strtolower($this->dom->doctype->publicId), 'strict') === false
		   && strpos(strtolower($this->dom->doctype->systemId), 'strict') === false) 
			$this->addReport(null, null, false);
	}
}