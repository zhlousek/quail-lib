<?php

class tableIsGrouped extends quailTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->elementHasChild($table, 'thead') 
					|| !$this->elementHasChild($table, 'tbody') 
					|| !$this->elementHasChild($table, 'tfoot')) {
				$rows = 0;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr')
						$rows ++;
				}
				if($rows > 4)
					$this->addReport($table);
			}		
		}
	
	}
}