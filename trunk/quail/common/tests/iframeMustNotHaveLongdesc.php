<?php

class iframeMustNotHaveLongdesc extends quailTest {

	function check() {
		foreach($this->getAllElements('iframe') as $iframe) {
			if($iframe->hasAttribute('longdesc'))
				$this->addReport($iframe);
		
		}
	}
}