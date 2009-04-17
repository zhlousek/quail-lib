<?php 

require_once('common/elements.php');
require_once('common/colors.php');

class quail508 {
	
	var $dom;
	
	var $css;
	
	var $guidelines;
	
	var $guideline_numbers = array('a', 'b', 'c', 'd', 'e', 'f', 'g');
	
	var $techniques;
	
	var $path;
	
	var $report;
	
	function __construct($dom, $css, $path) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->guidelines = new stdClass();
		$this->includeGuidelines();
		
	}
	
	function includeGuidelines() {
		foreach($this->guideline_numbers as $guideline) {
			require_once('508/'.$guideline.'.php');
			$classname = 'guideline'.ucfirst($guideline);
			$this->guidelines->$guideline = new $classname($this->dom, $this->css, $this->path);
		}
	}
	
	function getReport() {
		foreach($this->guidelines_numbers as $guideline) {
			$classname = 'guideline'. $guideline;
			$this->report[$guideline] = $this->$classname->report;
		}
		return $this->report;
	}
	
	function getTechnique($guideline, $technique = null) {
		return $this->guidelines->$guideline->check();
	}
	
}

class sect508Guideline {
	
	var $dom;
	
	var $css;
	
	var $report;
	
	var $guideline;
	
	var $report_on_all_elements;
	
	function __construct($dom, $css, $null = null) {
		$this->dom = $dom;
		$this->css = $css;
	}

	function getCheckpoints() {
		return $this->checkPoints();
	}
	
	function checkDocument() {
		$result = $this->check();
		if(count($result) > 0)
			$this->addToReport($result, $number);
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