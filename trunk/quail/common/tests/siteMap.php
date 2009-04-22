<?php

class siteMap extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(strtolower(trim($a->nodeValue)) == 'site map')
				return true;
		}
		$this->addReport(null, null, false);
	}
}