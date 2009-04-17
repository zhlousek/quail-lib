<?php

class guideline3 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'When an appropriate markup language exists, use markup rather than images to convey information.',
			'priority' => 2,
		),
		2 => array(
			'description' => 'Create documents that validate to published formal grammars.',
			'priority' => 2,
		),
		3 => array(
			'description' => 'Use style sheets to control layout and presentation.',
			'priority' => 2,
		),
		4 => array(
			'description' => 'Use relative rather than absolute units in markup language attribute values and style sheet property values.',
			'priority' => 2,
		),		
		5 => array(
			'description' => 'Use header elements to convey document structure and use them according to specification.',
			'priority' => 2,
		),
		6 => array(
			'description' => 'Mark up lists and list items properly.',
			'priority' => 2,
			'manual' => true,
		),
		7 => array(
			'description' => 'Mark up quotations. Do not use quotation markup for formatting effects such as indentation.',
			'priority' => 2,
			'manual' => true,
		),
	);
	
	var $guideline = 3;
	
	function checkpoint1() {

	}
	
	function checkpoint2() {
		$doctype = $this->getAllElements('!DOCTYPE');
		if(!count($doctype))
			$result[]['message'] = 'You should declare a doc type';
		return $result;
	}
	
	function checkpoint3() {
		$tags = htmlElements::getElementsByOption('non-emphasis');
		foreach($tags as $tagname) {
			$elements = $this->dom->getElementsByTagName($tagname);
			foreach($elements as $element) {
				$result[]['element'] = $element;
			}
			
		}
		foreach($this->getAllElements('font') as $element) {
			$result[]['element'] = $element;
		}
		foreach($this->getAllElements('img') as $element) {
			if(strpos($element->getAttribute('alt'), '&nbsp;') !== false)
				$result[]['element'] = $element;
		}
		
		return $result;
	}
	
	function checkpoint4() {
		foreach($this->css->getAllValuesForCode('font-size') as $option => $value) {
			if(strpos($value, 'em') === false && strpos($value, '%') === false)
				$result[]['message'] = 'CSS element '. $option .' should use em or percent';
		}
		return $result;
	}
	
	function checkpoint5() {
		if(count($this->getAllElements(null, 'headers')) < 0)
			$result[]['message'] = 'You should use headers to describe the structure of the page';
		
		return $result;
	}
	
	function checkpoint6() {
		$list_items = htmlElements::getElementsByOption('list');
		foreach($this->getAllElements($list_items) as $list) {
			foreach($list->childNodes as $child) {
				if(in_array($child->tagName, $list_items))
					$result[]['element'] = $list;
			}
		}
		return $result;
	}
	
	function checkpoint7() {
		foreach($this->getAllElements(null, 'quote') as $quote) {
			if(!$quote->hasAttribute('cite'))
				$result[]['element'] = $quote;
		}
		return $result;
	}
}