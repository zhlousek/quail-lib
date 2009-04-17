<?php

class guideline10 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Until user agents allow users to turn off spawned windows, do not cause pop-ups or other windows to appear and do not change the current window without informing the user',
			'priority' => 2,
		),
		2 => array(
			'description' => 'Until user agents support explicit associations between labels and form controls, for all form controls with implicitly associated labels, ensure that the label is properly positioned.',
			'priority' => 2,
		),
		3 => array(
			'description' => 'Until user agents (including assistive technologies) render side-by-side text correctly, provide a linear text alternative (on the current page or some other) for all tables that lay out text in parallel, word-wrapped columns',
			'priority' => 3,
		),
		4 => array(
			'description' => 'Until user agents handle empty controls correctly, include default, place-holding characters in edit boxes and text areas.',
			'priority' => 3,
		),		
		5 => array(
			'description' => 'Until user agents (including assistive technologies) render adjacent links distinctly, include non-link, printable characters (surrounded by spaces) between adjacent links.',
			'priority' => 3,
		),
	);
	
	var $guideline = 10;
	
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