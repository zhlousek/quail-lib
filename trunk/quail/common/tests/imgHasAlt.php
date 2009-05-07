<?php
/**
*   TEST 1 IN OAC
*	All img elements have an alt attribute.
*   Steps To Check
*   Procedure
*   1. Check each img element for the presence of an alt attribute.
*   Expected Result
*   1. All img elements have an alt attribute.
*   Failed Result
*   1. Add an alt attribute to each img element.
*	
*/
class imgHasAlt extends quailTest {
	
	/**
	*	@var int The OAC test Number
	*/
	var $oac_test = 1;

	/**
	*	@var int The test severity
	*/	
	var $severity = QUAIL_TEST_SEVERE;
	
	/**
	*	The check method of this test. We are iterating through all img
	*	elements and tagging any without an ALT attribute.
	*/
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(!$img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}