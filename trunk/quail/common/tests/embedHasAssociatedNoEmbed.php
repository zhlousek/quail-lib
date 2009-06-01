<?php

class embedHasAssociatedNoEmbed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if($embed->firstChild->tagName != 'noembed' &&
				$embed->nextSibling->tagName != 'noembed')
					$this->addReport($embed);
		
		}
	}
}