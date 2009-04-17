<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=5&lang=eng
*/
class imgImportantNoSpacerAlt extends quailTest {

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('src') && trim($img->getAttribute('alt')) == '') {
				if($img->getAttribute('width') > 25 || $img->getAttribute('height') > 25)
					$this->addReport($img);
				elseif(IMAGECLASS_EXISTS) {
					try {
						$img_file = wiImage::load($img->getAttribute('src'));
						
						
						if($img_file->getWidth() > 25 || $img_file->getHeight() > 25)
							$this->addReport($img);
					}
					catch(Exception $e) {
					
					}
				}
			}

		}
	
	}
}