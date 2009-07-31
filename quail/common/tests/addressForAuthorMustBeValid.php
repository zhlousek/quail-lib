<?php

class addressForAuthorMustBeValid extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $checkDomain = true;

	
	function check() {
		$this->includeValidate();
		
		foreach($this->getAllElements('address') as $address) {
			if (Validate::email($address->nodeValue, array('check_domain' => $this->checkDomain)))
				return true;
			foreach($address->childNodes as $child) {
				if($child->tagName == 'a' && substr(strtolower($child->getAttribute('href')), 0, 7) == 'mailto:') {
					if(Validate::email(trim(str_replace('mailto:', '', $child->getAttribute('href'))), 
						array('check_domain' => $this->checkDomain)))
							return true;
				
				}
			}
		}
		$this->addReport(null, null, false);
	}


	function includeValidate() {
		require_once('Validate.php');
	
	}
}