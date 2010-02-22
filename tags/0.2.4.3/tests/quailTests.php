<?php

class TestOfQuailTests extends UnitTestCase {
 
 function getTest($file, $test) {
 		$name = explode('-', $file);
 		
 		$filename = 'testfiles/quail/'. $file;
        $quail = new quail($filename, 'wcag1a', 'file');
		$quail->runCheck();
	
		return $quail->getTest($test);
 }
 
 function test_svgContainsTitle() {
		$results = $this->getTest('svgContainsTitle-fail.html', 'svgContainsTitle');
		$this->assertTrue($results[0]->element->tagName == 'svg');
		$results = $this->getTest('svgContainsTitle-pass.html', 'svgContainsTitle');
		$this->assertTrue(count($results) == 0);
 }
 
}

$tests = &new TestOfQuailTests();
$tests->run(new HtmlReporter());