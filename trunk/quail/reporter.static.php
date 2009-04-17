<?php



class reportStatic extends quailReport {
	
	var $translation;
	
	function __construct($guideline, $domain) {
		require_once('guidelines/'. $guideline .'/translations/'.$domain.'.php');
		$classname = 'translation'.ucfirst($guideline);
		$translation_class = new $classname();
		$this->translation = $translation_class->translation;
	}
	
	function getError($error) {
		if($this->translation[$error])
			return $this->translation[$error];
		return false;
	}

}