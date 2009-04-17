<?php


class objectLinkToMultimediaHasTextTranscript extends quailTest {

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->getAttribute('type') == 'video')
				$this->addReport($object);
			
		}
	}

}