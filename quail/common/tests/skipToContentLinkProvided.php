<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class skipToContentLinkProvided extends quailTest {
	
	var $search_words = array('navigation', 'skip', 'content');
	
	function check() {
		$body = $this->getAllElements('body');
		$first_link = $this->getAllElements('a');
		if(!$first_link) {
			$this->addReport($body[0]);
			return false;
		}
		$a = $first_link[0];
		
		if(substr($a->getAttribute('href'), 0, 1) == '#') {
			
			$link_text = explode(' ', strtolower($a->nodeValue));
			if(!in_array($this->search_words, $link_text)) {
				$report = true;
				foreach($a->childNodes as $child) {
					if($child->hasAttribute('alt')) {
						$alt = explode(' ', strtolower($child->getAttribute('alt') . $child->nodeValue));
						foreach($this->search_words as $word) {
							if(in_array($word, $alt)) 
								$report = false;
						}
					}
				}
				if($report)
					$this->addReport($body[0]);
			}
		
		}
		else
			$this->addReport($body[0]);

	}

}