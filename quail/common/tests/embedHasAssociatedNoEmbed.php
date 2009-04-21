<?php

class embedHasAssociatedNoEmbed extends quailTest {

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if($embed->firstChild->tagName != 'noembed' &&
				$embed->nextSibling->tagName != 'noembed')
					$this->addReport($embed);
		
		}
	}
}