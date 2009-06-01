<?php

class documentAllColorsAreSet extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $color_attributes = array('text', 'bgcolor', 'link', 'alink', 'vlink');
	
	function check() {
		$body = $this->getAllElements('body');
		$body = $body[0];
		if($body) {
			$colors = 0;
			foreach($this->color_attributes as $attribute) {
				if($body->hasAttribute($attribute))
					$colors++;
			}
			if($colors > 0 && $colors < 5)
				$this->addReport(null, null, false);
		}
	}
}