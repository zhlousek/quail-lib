<?php

class guideline7 extends wcagGuideline {
	
	var $checkpoints = array(
		1 => array(
			'description' => 'Until user agents allow users to control flickering, avoid causing the screen to flicker.',
			'priority' => 1,
		),
		2 => array(
			'description' => 'Until user agents allow users to control blinking, avoid causing content to blink (i.e., change presentation at a regular rate, such as turning on and off).',
			'priority' => 2,
		),
		3 => array(
			'description' => 'Until user agents allow users to freeze moving content, avoid movement in pages.',
			'priority' => 2,
		),
		4 => array(
			'description' => 'Until user agents provide the ability to stop the refresh, do not create periodically auto-refreshing pages.',
			'priority' => 2,
		),		
		5 => array(
			'description' => 'Until user agents provide the ability to stop auto-redirect, do not use markup to redirect pages automatically.',
			'priority' => 2,
		),
	
	);
	
	var $guideline = 7;
	
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