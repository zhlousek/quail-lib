<?php


class objectLinkToMultimediaHasTextTranscript extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->getAttribute('type') == 'video')
				$this->addReport($object);
			
		}
	}

}