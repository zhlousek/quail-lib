<?php

class tableUsesCaption extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->firstChild->tagName != 'caption')
				$this->addReport($table);
			
		}
	
	}
}