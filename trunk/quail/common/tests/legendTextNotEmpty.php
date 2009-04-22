<?php

class legendTextNotEmpty extends quailTest {

	function check() {
		foreach($this->getAllElements('legend') as $legend) {
			if(!$legend->nodeValue || trim($legend->nodeValue) == '')
				$this->addReport($legend);
		}
	}
}