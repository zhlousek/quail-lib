<?php
include('../quail/common/css.php');
class cssTestInterface {

	var $dom;
	
	var $file_base = 'testfiles/css/';
	
	function __construct($filename) {
		$filename = $this->file_base . $filename;
		$this->dom = new DOMDocument();
		$this->dom->loadHTMLFile($filename);
		$this->css = new quailCSS($this->dom, $filename, 'file');
	}
	
	function renderHTML() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			$style = $this->css->getStyle($element);
			$element->setAttribute('title' , 'b: '. $style['background-color'] .' f: '. $style['color']);
		}
		return $this->dom->saveHTML();
	}
}

$test = new cssTestInterface('cssComplexTest1.html');
/*print_r($test->css->dom_index);
foreach($test->css->dom_index as $i) {
	print $i[0]['element']->tagName .'<br>';
	print_r($i[0]['style']);
	print '<hr>';

}*/
print $test->renderHTML();