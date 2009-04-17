<?php

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksToSoundFilesNeedTranscripts extends quailTest {
	
	var $extensions = array('wav', 'snd', 'mp3', 'iff', 'svx', 'sam', 'smp', 'vce', 'vox', 'pcm', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$filename = explode('.', $a->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}

}