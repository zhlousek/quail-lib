<?php

/**
*	A static reporter. Generates a list of errors which do not pass and their severity.
*	This is just a demonstration of what you can do with a reporter.
*/

class reportStatic extends quailReporter {
	
	/**
	*	Generates a static list of errors within a div.
	*	@return string A fully-formatted report
	*/
	function getReport() {
		foreach($this->guideline->getReport() as $testname => $test) {
			if(count($test) > 0) {
				$severity = $this->guideline->getSeverity($testname);
				$output .= '<div><h3>'. $this->translation[$testname] .'</h3>';
				foreach($test as $k => $problem) {
					if(is_object($problem))
						$output .= '<p><strong>'.($k+1).'</strong><pre>'. htmlentities($problem->getHtml()) .'</pre></p>';
					
				}
				$output .='</p>';
				switch($severity) {
					case QUAIL_TEST_SEVERE:
						$output .= 'Severe error';
						break;
					case QUAIL_TEST_MODERATE:
						$output .= 'Moderate error';
						break;
					case QUAIL_TEST_SUGGESTION:
						$output .= 'Suggestion';
						break;
				}
				$output .='</p></div>';
			}
		}
		return $output;
	}
}