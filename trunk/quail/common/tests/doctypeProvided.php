<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class doctypeProvided extends quailTest {

	function check() {
		if(!$this->dom->doctype->publicId)
			$this->addReport(null, null, false);		
	}

}