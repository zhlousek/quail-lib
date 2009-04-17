<?php 

class quailWcag {
	
	var $dom;
	
	var $css;
	
	var $guidelines;
	
	var $principle_numbers = array();
	
	var $technique_numbers = array();
	
	var $techniques;
	
	var $path;
	
	var $report;
	
	function __construct($dom, $css, $path) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->techniques = new stdClass();
		$this->includePrinciples();
		
	}
	
	
	function includePrinciples() {
		foreach ($this->principle_numbers as $principle) {
			require_once('wcag/principle'. $principle .'.php');
			$classname = 'principle'. $principle;
			$this->principles[] = $classname;
			$this->$classname = new $classname($this->dom, $this->css, $this->techniques, $this->path);
			$this->$classname->checkDocument();
		}	
	}
	
	function getReport() {
		foreach($this->principle_numbers as $principle) {
			$classname = 'principle'. $principle;
			$this->report[$principle] = $this->$classname->report;
		}
		return $this->report;
	}
	
	function getDescription($principle, $checkpoint) {
		$principle = 'principle'.$principle;
		return $this->$principle->checkpoints[$checkpoint]['description'];
	}
	
	function getTechnique($type, $technique) {
		return $this->techniques->$type->$technique();
	}
	
}

class wcagPrinciple {
	
	var $dom;
	
	var $css;
	
	var $checkpoints;
	
	var $techniques;
	
	var $scored_elements;
	
	var $report;
	
	var $report_on_all_elements;
	
	function __construct($dom, $css, $techniques) {
		$this->dom = $dom;
		$this->css = $css;
		$this->techniques = $techniques;
	}

	function getCheckpoints() {
		return $this->checkPoints();
	}
	
	function checkDocument() {
		foreach($this->guidelines as $number => $guideline) {
			$method_name = $guideline['method'];
			$result = $this->$method_name();
			if(count($result) > 0)
				$this->addToReport($result, $number);
		}
	}
		
	function addToReport($results, $checkpoint) {
		foreach($results as $result) {
			$item = new quailReportItem();
			if($result['message']) 
				$item->message = $result['message'];
			if($result['element'])
				$item->element = $result['element'];
			$item->level = $this->guidelines[$checkpoint]['level'];
			$item->manual = $this->guidelines[$checkpoint]['manual'];
			$item->checkpoint = $checkpoint;
			$item->principle = $this->principle;
			$this->report[$checkpoint][] = $item;
		}	
	}

	

}