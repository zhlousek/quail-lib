<?php

class documentVisualListsAreMarkedUp extends quailTest {

	var $list_cues = array('*', '<br>*', '¥', '&#8226');
	
	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			foreach($this->list_cues as $cue) {
				$first = stripos($text->nodeValue, $cue);
				$second = strripos($text->nodeValue, $cue);
				if($first && $second && $first != $second)
					$this->addReport($text);
			}
		}
	
	}
}