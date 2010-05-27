<?php

class youtubeService {
	
	var $regex = array(
	    '@youtube\.com/v/([^"\& ]+)@i',
	    '@youtube\.com/watch\?v=([^"\& ]+)@i',
	    '@youtube\.com/\?v=([^"\& ]+)@i',
		);
		
	var $search_url = 'http://gdata.youtube.com/feeds/api/videos?q=%s&caption&v=2';
	
	private function isYouTubeVideo($link_url) {
		$matches = null; 
		foreach($this->regex as $pattern) {
			if(preg_match($pattern, trim($link_url), $matches)) {
				return $matches[1];
			}
		}
		return false;
	}
	
	function captionsMissing($link_url) {
	
		if($code = $this->isYouTubeVideo($link_url)) {
			$result = file_get_contents(sprintf($this->search_url, $code));
			
			if (strpos($result, 'video:'. $code) === false) {
				return true;
			}
		}
		return false;
	}
} 