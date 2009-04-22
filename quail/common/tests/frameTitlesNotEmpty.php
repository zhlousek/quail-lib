<?php

class frameTitlesNotEmpty extends quailTest {

	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title') || trim($frame->getAttribute('title')) == '')
				$this->addReport($frame);
		}
	}
}