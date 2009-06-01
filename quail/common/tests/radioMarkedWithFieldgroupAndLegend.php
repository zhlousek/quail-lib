<?php

class radioMarkedWithFieldgroupAndLegend extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'radio') {
				$radios[$input->getAttribute('name')][] = $input;
			}
		}
		if(is_array($radios)) {
			foreach($radios as $radio) {
				if(count($radio > 1)) {
					if(!$this->getParent($radio[0], 'fieldset', 'body'))
						$this->addReport($radio[0]);
				}
			}
		}
	}
}