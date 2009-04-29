<?php

class headersUseToMarkSections extends quailTest {
	
	var $non_header_tags = array('strong', 'b', 'em', 'i');
	
	function check() {
		$headers = $this->getAllElements(null, 'header');
		$paragraphs = $this->getAllElements('p');
		if(count($headers) == 0 && count($paragraphs) > 1)
			$this->addReport(null, null, false);
		foreach($paragraphs as $p) {
			if(in_array($p->firstChild->tagName, $this->non_header_tags)
			   || in_array($p->firstChild->nextSibling->tagName, $this->non_header_tags)
			   || in_array($p->previousSibling->tagName, $this->non_header_tags))
				$this->addReport($p);
		}
	}
}