<?php

class liDontUseImageForBullet extends quailTest {

	function check() {
		foreach($this->getAllElements('li') as $li) {
			if(trim($li->nodeValue) != '' && $li->firstChild->tagName == 'img')
				$this->addReport($li);
		}
	
	}
}