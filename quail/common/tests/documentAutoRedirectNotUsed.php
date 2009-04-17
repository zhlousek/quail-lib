<?php


class documentAutoRedirectNotUsed extends quailTest {

	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->hasAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}