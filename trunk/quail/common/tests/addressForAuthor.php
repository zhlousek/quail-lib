<?php

class addressForAuthor extends quailTest {

	function check() {
		foreach($this->getAllElements('address') as $address) {
			foreach($address->childNodes as $child) {
				if($child->tagName == 'a')
						return true;
			}
		}
		$this->addReport(null, null, false);
	}

}