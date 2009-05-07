<?php



class objectMustHaveValidTitle extends quailTest {

	var $placeholders = array('nbsp', '&nbsp;', 'object', 'an object', 'spacer', 'image', 'img', 'photo', ' ');

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->hasAttribute('title')) {
				if(trim($object->getAttribute('title')) == '')
					$this->addReport($object);
				elseif(!in_array(trim(strtolower($object->getAttribute('title'))), $this->placeholders))
					$this->addReport($object);
			}
		}
	}

}