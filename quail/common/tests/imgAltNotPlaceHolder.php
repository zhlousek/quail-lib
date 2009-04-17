<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltNotPlaceHolder extends quailTest {
	
	var $placeholders = array('nbsp', '&nbsp;', 'spacer', 'image', 'img', 'photo', ' ');
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(in_array($img->getAttribute('alt'), $this->placeholders) || ord($img->getAttribute('alt')) == 194) {
				$this->addReport($img);
			}
			elseif(preg_match("/^([0-9]*)(k|kb|mb|k bytes|k byte)?$/", strtolower($img->getAttribute('alt')))) {
				$this->addReport($img);
			}

		}
	
	}
}