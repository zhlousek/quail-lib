<?php

class imageMapServerSide extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('ismap'))
				$this->addReport($img);
		}
	
	}
}