<?php

class guideline9 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Provide client-side image maps instead of server-side image maps except where the regions cannot be defined with an available geometric shape.',
			'priority' => 1,
		),
		2 => array(
			'description' => 'Ensure that any element that has its own interface can be operated in a device-independent manner.',
			'priority' => 2,
		),
		3 => array(
			'description' => 'For scripts, specify logical event handlers rather than device-dependent event handlers.',
			'priority' => 2,
		),
		4 => array(
			'description' => 'Create a logical tab order through links, form controls, and objects.',
			'priority' => 3,
		),		
		5 => array(
			'description' => 'Provide keyboard shortcuts to important links (including those in client-side image maps), form controls, and groups of form controls.',
			'priority' => 3,
		),
	);
	
	var $guideline = 9;
	
	function checkpoint1() {

	}
	
	function checkpoint2() {
		
	}
	
	function checkpoint3() {

	}
	
	function checkpoint4() {
		
	}
	
	function checkpoint5() {

	}
	
}