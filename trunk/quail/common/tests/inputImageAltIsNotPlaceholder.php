<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class inputImageAltIsNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $placeholders = array('nbsp', '&nbsp;', 'input', 'spacer', 'image', 'img', 'photo', ' ');
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image') {
				if(in_array($input->getAttribute('alt'), $this->placeholders) || ord($input->getAttribute('alt')) == 194) {
					$this->addReport($input);
				}
				elseif(preg_match("/^([0-9]*)(k|kb|mb|k bytes|k byte)?$/", strtolower($input->getAttribute('alt')))) {
					$this->addReport($input);
				}
			}
		}
	
	}
}