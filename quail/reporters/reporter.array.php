<?php

/**
*	An array reporter that simply returns an unformatted and nested PHP array of 
*	tests and report objects
*/

class reportArray extends quailReporter {
	
	/**
	*	Generates a static list of errors within a div.
	*	@return array A nested array of tests and problems with Report Item objects
	*/
	function getReport() {
		foreach($this->guideline->getReport() as $testname => $test) {
			$output[$testname]['severity'] = $this->guideline->getSeverity($testname);
			$output[$testname]['title'] =  $this->translation[$testname];
			$output[$testname]['problems'] = $test;
		}
		return $output;
	}
}