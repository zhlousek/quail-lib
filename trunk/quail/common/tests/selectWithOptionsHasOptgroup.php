<?php

class selectWithOptionsHasOptgroup extends quailTest {

	function check() {
		foreach($this->getAllElements('select') as $select) {
			$options = 0;
			foreach($select->childNodes as $child) {
				if($child->tagName == 'option')
					$options++;
			}
			if($options >= 4)
				$this->addReport($select);
		}
	}
}