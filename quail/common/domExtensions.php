<?php

class QuailDOMElement extends DOMElement {

	var $css_style;
	
	function setCSS($css) {
		$this->css_style = $css;
	}
	
	function getStyle($style = false) {
		if(!$style)
			return $this->css_style;
		else return $this->css_style[$style];
	}
}