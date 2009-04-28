<?php


class tableSummaryDoesNotDuplicateCaption extends quailTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->elementHasChild($table, 'caption') && $table->hasAttribute('summary')) {
				foreach($table->childNodes as $child) {
					if($child->tagName == 'caption')
						$caption = $child;
				}
				if(strtolower(trim($caption->nodeValue)) == 
						strtolower(trim($table->getAttribute('summary'))) ) 
				 $this->addReport($table);
				
			}
		}
	}
}