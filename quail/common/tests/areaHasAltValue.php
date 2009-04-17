<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaHasAltValue extends quailTest {

	function check() {
		foreach($this->getAllElements('area') as $area) {
			if(!$area->hasAttribute('alt'))
				$this->addReport($area);
		}
	}

}