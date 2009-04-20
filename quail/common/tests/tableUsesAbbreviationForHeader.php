<?php

class tableUsesAbbreviationForHeader extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			foreach($table->childNodes as $child) {
				if($child->tagName == 'tr') {
					foreach($child->childNodes as $td) {
						if($td->tagName == 'th') {
							if(strlen($td->nodeValue) > 20 && !$td->hasAttribute('abbr'))
								$this->addReport($table);
						
						}
					}
				}
			}
			
		}
	
	}
}