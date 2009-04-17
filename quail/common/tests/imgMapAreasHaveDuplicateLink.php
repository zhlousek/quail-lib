<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgMapAreasHaveDuplicateLink extends quailTest {
	
	var $placeholders = array('nbsp', '&nbsp;', 'spacer', 'image', 'img', 'photo', ' ');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			$all_links[$a->getAttribute('href')] = $a->getAttribute('href');
		}
		$maps = $this->getElementsByAttribute('map', 'name', true);
		
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('usemap')) {
				$usemap = $img->getAttribute('usemap');
				if(substr($usemap, 0, 1) == '#')
					$key = substr($usemap, -(strlen($usemap) - 1), (strlen($usemap) - 1));
				else
					$key = $usemap;
				foreach($maps[$key]->childNodes as $child) {
					if($child->tagName == 'area') {
						
						if(!$all_links[$child->getAttribute('href')])
							$this->addReport($img);
					}
				}
			
			
			}
		}
	
	}
}