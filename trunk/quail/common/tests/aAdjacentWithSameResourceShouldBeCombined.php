<?php

class aAdjacentWithSameResourceShouldBeCombined extends quailTest {

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(trim($a->nextSibling->wholeText) == '')
				$next = $a->nextSibling->nextSibling;
			else
				$next = $a->nextSibling;
			if($next->tagName == 'a') {
				if($a->getAttribute('href') == $next->getAttribute('href'))
					$this->addReport($a);
			}
		}
	}
}