<?php

class techniqueHtml extends wcagTechnique {
	
	var $emoticons = array('<3', ':(|)', '\m/', ':-o', ':D', ':(', 
						   'x-(', 'B-)', ':\'(', '=D', ';)', ':-|', 
						   '=)', ':-D', ';^)', ';-)', ':-)', ':-/',
						   ':P');
	/**
	*  Combining adjacent image and text links for the same resource
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/H2
	*/
	function h2() {
		$result = array();
		foreach($this->getAllElements('a') as $element) {
			if(!$all_links[$element->getAttribute('href')]) {
				$parent = $element->parentNode;
				$all_links = array();
				foreach($parent->childNodes as $child) {
					if($child->tagName == 'a') {
						if($all_links[$child->getAttribute('href')]) {
							$first = $all_links[$child->getAttribute('href')];
							if($child->hasChildNodes()) {
								foreach($child->childNodes as $a_child) {
									if($a_child->tagName == 'img')
										$result[]['element'] = $child;
								}
							}
							if($first->hasChildNodes()) {
								foreach($first->childNodes as $a_child) {
									if($a_child->tagName == 'img')
										$result[]['element'] = $child;
								}
							}					
						}
						else
							$all_links[$child->getAttribute('href')] = $child;
					}
				}
			}
					
		}
		return $result;
	}

	/**	
	* Creating a logical tab order through links, form controls, and objects 
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H4
	*/
	function h4() {
		$result = array();
		foreach($this->getAllElements(null, 'form') as $element) {
			if($element->hasAttribute('tabindex'))
				$result[]['element'] = $element;		
		}
		foreach($this->getAllElements('a') as $element) {
			if($element->hasAttribute('tabindex'))
				$result[]['element'] = $element;
		}
		return $result;		
	}
	
	/**	
	* Providing text alternatives for the area elements of image maps 
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H24
	*/
	function h24() {
		$result = array();
		foreach($this->getAllElements('area') as $element) {
			if(!$element->hasAttribute('alt')) 
				$result[]['element'] = $element;
		
		}
		return $result;		
	}


	/**	
	* Providing a title using the title element
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H25
	*/
	function h25() {
		$result = array();
		foreach($this->getAllElements('head') as $element) {
			$head = false;
			foreach($element->childNodes as $child) {
				if($child->tagName == 'title')
					$head = true;
			}
		
		}
		if(!$head)
			$result[]['element'] = $element;
		return $result;		
	}

	/**	
	* Providing text and non-text alternatives for object
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H27
	*/
	function h27() {
		$result = array();
		foreach($this->getAllelements('object') as $element) {
			if(!$element->nodeValue)
				$result[]['element'] = $element;
		}
		return $result;		
	}

	/**	
	* Providing definitions for abbreviations by using the abbr and acronym elements
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H28
	*/
	function h28() {
		$abbr_tags = htmlElements::getElementsByOption('acronym');
		$result = array();
		foreach($this->getAllElements(null, 'text') as $element) {
			$check_abbr = false;
			foreach($element->childNodes as $child) {
				if(in_array($child->tagName, $abbr_tags) && $child->hasAttribute('title')) {
					$check_abbr = true;
					$predefined[strtoupper($child->nodeValue)] = true;
				}
			}
			if(!$check_abbr) {
				$words = explode(' ', $element->nodeValue);
				if(count($words) > 1 && strtoupper($element->nodeValue) != $element->nodeValue) {
					foreach($words as $word) {
						if(strtoupper($word) == $word && strlen($word) > 1 && !$predefined[$word])
							$result[]['element'] = $element;
					}
				}
			}		
		}
		return $result;		
	}

	/**
	*  Providing link text that describes the purpose of a link for anchor elements 
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/H30
	*/
		
	function h30() { 
		$results = array();
		foreach($this->getAllElements('a') as $element) {
			$has_alt = false;
			foreach($element->childNodes as $child) {
				if($child->tagName == 'img' && $child->hasAttribute('alt')) {
					$has_alt = true;
				}
			}
			if(!$has_alt && !$element->nodeValue)
				$results[]['element'] = $element;
		}
		return $results;
	}

	/**
	*  Providing submit buttons
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/H32
	*/
		
	function h32() { 
		$results = array();
		foreach($this->getAllElements('form') as $element) {
			$has_submit = false;
			foreach($element->childNodes as $child) {
				if($child->tagName == 'button' && $child->getAttribute('type') == 'submit')
					$has_submit = true;
				if($child->tagName == 'input' && ($child->getAttribute('type') == 'submit'
													|| $child->getAttribute('type') == 'image'))
					$has_submit = true;
					
			}
			if(!$has_submit) 
				$results[]['element'] = $element;
		}
		return $results;
	}



	/**
	*  Providing text alternatives on applet elements 
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H35
	*/
		
	function h35() { 
		$results = array();
		foreach($this->getAllElements('applet') as $element) {
			if(!$element->hasAttribute('alt') || strlen(trim($element->nodeValue)) == 0)
				$results[]['element'] = $element;
		}	
		return $results;
	}
	
	/**
	*  Using alt attributes on images used as submit buttons
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/H36
	*/
	
	function h36() {
		$image_buttons = $this->getElementsByAttribute('input', 'type');
		if(!is_array($image_buttons['image']))
			return array();
		$result = array();
		foreach($image_buttons['image'] as $button) {
			if(!$button->hasAttribute('alt'))
				$result[]['element'] = $button;
		}
		
		return $result;
	}
	
	/**
	*  Using alt attributes on img elements
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H37
	*/
		
	function h37() { 
		$results = array();
		foreach($this->getAllElements('img') as $element) {
			if(!$element->hasAttribute('alt'))
				$results[]['element'] = $element;
		}	
		return $results;
	}
	
	/**
	*  Using label elements to associate text labels with form controls
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H44
	*/
		
	function h44() {
		$result = array();
		$labels = $this->getElementsByAttribute('label', 'for', true);
		foreach($this->getAllElements(array('input', 'textarea', 'select')) as $inputs)  {
			if(!$labels[$inputs->getAttribute('id')])
				$result[]['element'] = $inputs;
		}
		return $result;
	}

	/**
	*  Using longdesc
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H45
	*/
		
	function h45() {
		$result = array();
		foreach($this->getAllElements(false, 'text', false) as $element) {
			if($element->hasAttribute('longdesc'))
				$result[]['element'] = $element;
		}
		return $result;
	}

	/**
	*  Using the body of the object element
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H53
	*/
		
	function h53() {
		$result = array();
		foreach($this->getAllElements('object') as $element) {
			if(strlen(trim($element->nodeValue)) == 0)
				$result[]['element'] = $element;
		}
		return $result;
	}
	
	/**
	*  Using the title attribute to identify form controls when the label element cannot be used
	*
	*  @link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H65
	*/
		
	function h65() {
		$result = array();
		$labels = $this->getElementsByAttribute('label', 'for');
		foreach($this->getAllElements(array('input', 'textarea', 'select')) as $inputs)  {
			if(!$labels[$inputs->getAttribute('id')] && !$inputs->hasAttribute('title'))
					$result[]['element'] = $inputs;
		}
		return $result;
	}
	
	/**
	*	Using null alt text and no title attribute on img elements for images that AT should ignore
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/html.html#H67
	*/
	
	function h67() {
		$result = array();
		foreach($this->getAllElements('img') as $image) {
			if($image->hasAttribute('src')) {
				if(IMAGECLASS_EXISTS) {
					try {
						$img_file = wiImage::load($image->getAttribute('src'));
						if($img_file->isTransparent() && !$image->hasAttribute('title') &&	
							(!$image->hasAttribute('alt') || !is_null(trim($image->getAttribute('alt')))) ) 
								$result[]['element'] = $image;
					}
					catch(Exception $e) {
					
					}
				}
			}
		}
		return $result;
	}
	
	/**
	*	Providing text alternatives for ASCII art, emoticons, and leetspeak
	*
	*	@link http://www.w3.org/TR/2008/NOTE-WCAG20-TECHS-20081211/H86
	*/
	function h86() {
		$results = array();
		foreach($this->getAllElements(null, 'text') as $element) {
			if($element->tagName !== 'abbr') {
				$abbrs = array();
				foreach($this->emoticons as $emoticon) {
					foreach($element->childNodes as $child) {
						if($child->tagName == 'abbr')
							$abbr[$child->nodeValue] = true;
					}
					if(strpos($element->nodeValue, $emoticon) !== false 
						&& !$abbr[$emoticon])
						$results[]['element'] = $element;
				}
			}
		}
		return $results;
	}

}