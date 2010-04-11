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
  function test_cssTextHasContrast() {
   $results = $this->getTest('cssContrast.html', 'cssTextHasContrast');
   $this->assertTrue($results[0]->element->tagName == 'p');
 }
 
 function test_complexCssTextHasContrast() {
   $results = $this->getTest('cssContrast2.html', 'cssTextHasContrast');
  
   $this->assertTrue($results[0]->element->tagName == 'p');
 }
 
 function test_cssTextContrastWithColorConversion() {
	$results = $this->getTest('cssContrast3.html', 'cssTextHasContrast');
	$this->assertTrue($results[0]->element->tagName == 'div');
	
 }

 function test_cssTextContrastWithComplexBackground() {
	$results = $this->getTest('cssContrast4.html', 'cssTextHasContrast');
	$this->assertTrue($results[0]->element->tagName == 'pre');
	
 }
  function test_cssTextContrastWithInlineAndIncludedFiles() {
	$results = $this->getTest('cssContrast5.html', 'cssTextHasContrast');
	$this->assertTrue($results[0]->element->tagName == 'pre');
	
 }
}

$tests = &new TestOfQuailTests();
$tests->run(new HtmlReporter());