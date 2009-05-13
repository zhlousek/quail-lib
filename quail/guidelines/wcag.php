<?php 

class WcagGuideline extends quailGuideline{
	
	var $tests = array(
		'imgHasAlt' => array('severity' => QUAIL_TEST_SEVERE),
		'aSuspiciousLinkText' => array('severity' => QUAIL_TEST_SEVERE),
	);
}