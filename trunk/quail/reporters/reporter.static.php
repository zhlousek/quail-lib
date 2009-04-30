<?php



class reportStatic extends quailReporter {
	
	
	function getReport() {
		foreach($this->guideline->getReport() as $testname => $test) {
			$output .= '<h1>'. $this->translation[$testname] .'</h1>';
			foreach($test as $k => $problem) {
				$output .= '<p><strong>'.($k+1).'</strong><pre>'. htmlentities($problem->getHtml()) .'</pre></p>';
			
			}
		}
		return $output;
	}
}