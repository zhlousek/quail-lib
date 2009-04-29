<?php 

class tabIndexFollowsLogicalOrder extends quailTest {
	
	function check() {
		$index = 0;
		foreach($this->getAllElements(null, 'form') as $form) {
			if(is_numeric($form->getAttribute('tabindex'))
				&& intval($form->getAttribute('tabindex')) != $index + 1)
					$this->addReport($form);
			$index++;
		}
	}
}