<?php

class documentIDsMustBeUnique extends quailTest {
	
	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			if($element->hasAttribute('id'))
				$ids[$element->getAttribute('id')][] = $element;
		}	
		foreach($ids as $id) {
			if(count($id) > 1)
				$this->addReport($id[1]);
		}
	}
}