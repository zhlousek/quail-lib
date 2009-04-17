<?php


class documentMetaNotUsedWithTimeout extends quailTest {

	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->getAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}