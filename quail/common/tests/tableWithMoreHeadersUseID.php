<?php

class tableWithMoreHeadersUseID extends quailTableTest {

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->isData($table)) {
				
				$row = 0;
				$multi_headers = false;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr') {
						$row ++;
						foreach($child->childNodes as $cell) {
							if($cell->tagName == 'th') {
								$th[] = $cell;
								if($row > 1) 
									$multi_headers = true;	
							}
								
						}
					}
				}
				if($multi_headers) {
					$fail = false;
					foreach($th as $cell) {
						if(!$cell->hasAttribute('id'))
							$fail = true;
					}
					if($fail)
						$this->addReport($table);
				} 
				
			}
		}
	}
}