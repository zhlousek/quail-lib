<?php

class htmlElements {

	static $html_elements = array(
		'img' 	 => array('text' => false),
		'p' 	 => array('text' => true),
		'span' 	 => array('text' => true),
		'div' 	 => array('text' => true),
		'applet' => array('text' => false),
		'embed'  => array('text' => false, 'media' => true),
		'object' => array('text' => false, 'media' => true),
		'area' 	 => array('imagemap' => true),
		'b' 	 => array('text' => true, 'non-emphasis' => true),
		'i' 	 => array('text' => true, 'non-emphasis' => true),
		'font' 	 => array('text' => true, 'font' => true),
		'h1'	 => array('text' => true, 'header' => true),
		'h2'	 => array('text' => true, 'header' => true),
		'h3'	 => array('text' => true, 'header' => true),
		'h4'	 => array('text' => true, 'header' => true),
		'h5'	 => array('text' => true, 'header' => true),
		'h6'	 => array('text' => true, 'header' => true),
		'ul'	 => array('text' => true, 'list' => true),
		'dl'     => array('text' => true, 'list' => true),
		'ol' 	 => array('text' => true, 'list' => true),
		'blockquote' => array('text' => true, 'quote' => true),
		'q'		 => array('text' => true, 'quote' => true),
		'acronym' => array('acronym' => true, 'text' => true),
		'abbr'   => array('acronym' => true, 'text' => true),
		'input'  => array('form' => true),
		'checkbox' => array('form' => true),
		'select' => array('form' => true),
		'textarea' => array('form' => true),
		
	);
	
	function getElementsByOption($option, $value = true) {
		foreach(self::$html_elements as $k => $element) {
			if($element[$option] == $value)
				$results[] = $k;
		}
		return $results;
	}
}