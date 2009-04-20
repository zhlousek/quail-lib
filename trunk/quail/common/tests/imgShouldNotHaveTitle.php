<?php

class imgShouldNotHaveTitle extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('title'))
				$this->addReport($img);
		}
	
	}
}