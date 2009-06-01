<?php
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgGifNoFlicker extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $gif_control_extension = "/21f904[0-9a-f]{2}([0-9a-f]{4})[0-9a-f]{2}00/";
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			
			if(substr($img->getAttribute('src'), -4, 4) == '.gif') {

				$file = file_get_contents($this->getPath($img->getAttribute('src')));
					  $file = bin2hex($file);
					
					  // sum all frame delays
					  $total_delay = 0;
					  preg_match_all($this->gif_control_extension, $file, $matches);
					  foreach ($matches[1] as $match) {
					    // convert little-endian hex unsigned ints to decimals
					    $delay = hexdec(substr($match,-2) . substr($match, 0, 2));
					    if ($delay == 0) $delay = 1;
					    $total_delay += $delay;
					  }
					
					  // delays are stored as hundredths of a second, lets convert to seconds
					  
					 
					 if($total_delay > 0)
					 	$this->addReport($img);
	
			}
		}
	
	}
}
