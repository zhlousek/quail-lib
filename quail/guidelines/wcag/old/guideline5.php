<?php

class guideline5 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'For data tables, identify row and column headers.',
			'priority' => 1,
		),
		2 => array(
			'description' => 'For data tables that have two or more logical levels of row or column headers, use markup to associate data cells and header cells.',
			'priority' => 1,
		),
		3 => array(
			'description' => 'Do not use tables for layout unless the table makes sense when linearized.',
			'priority' => 2,
		),
		4 => array(
			'description' => 'If a table is used for layout, do not use any structural markup for the purpose of visual formatting.',
			'priority' => 2,
		),		
		5 => array(
			'description' => 'Provide summaries for tables.',
			'priority' => 3,
		),
		6 => array(
			'description' => 'Provide abbreviations for header labels.',
			'priority' => 3,
		),
	);
	
	var $guideline = 5;
	
	function checkpoint1() {
		if(count($this->getAllElements('pre')) > 0)
			$result[]['message'] = 'Check that all items under PRE are not tabular data. If so, convert to a table';
		foreach($this->getAllElements('table') as $table) {
			if(!$this->elementHasChild('th'))
				$result[]['element'] => $table;
		}
		
		return $result;		
	}
	
	function checkpoint2() {
			
	}
	
	function checkpoint3() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->elementHasCHild('th'))
				$result[]['element'] = $table;
		}
		return $result;
	}
	
	function checkpoint4() {
		
	}
	
	function checkpoint5() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->elementHasChild($table, 'caption') 
					&& !$table->hasAttribute('title') && !$table->hasAttribute('summary'))
				$result[]['element'] = $table;
		}
		return $result;
	}
	
	function checkpoint6() {
		foreach($this->getAllElements('th') as $th) {
			if(!$th->hasAttribute('abbr'))
				$result[]['element'] = $th;
		}
		return $result;
	}
	
}