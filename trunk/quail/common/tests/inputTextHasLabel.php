<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputTextHasLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $tag = 'input';
	
	var $type = 'text';
	
	var $no_type = false;
}