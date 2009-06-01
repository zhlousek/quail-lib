<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaLinksToSoundFile extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wav', 'snd', 'mp3', 'iff', 'svx', 'sam', 'smp', 'vce', 'vox', 'pcm', 'aif');
	
	function check() {
		foreach($this->getAllElements('area') as $area) {
			if($area->hasAttribute('href')) {
				$filename = explode('.', $area->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($area);
			}
		}
	}

}