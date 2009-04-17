<?php

class blockquoteNotUsedForIndentation extends quailTest {

	function check() {
		foreach($this->getAllElements('blockquote') as $blockquote) {
			if(!$blockquote->hasAttribute('cite'))
				$this->addReport($blockquote);
		}
	}
}