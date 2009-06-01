<?php

class liDontUseImageForBullet extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATe;

	function check() {
		foreach($this->getAllElements('li') as $li) {
			if(trim($li->nodeValue) != '' && $li->firstChild->tagName == 'img')
				$this->addReport($li);
		}
	
	}
}