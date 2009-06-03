<?php

/**
*	The base class for all QUAIL tests. This handles importing DOM objects, adding items
*	to the report and provides a few DOM-traversing methods
*/
class quailTest {

	/**
	*	@var object The DOMDocument object 
	*/
	var $dom;
	
	/**
	*	@var object The QuailCSS object
	*/
	var $css;
	
	/**
	*	@var array The path for the request
	*/
	var $path;
	
	/**
	*	@var string The base path for this request
	*/
	var $base_path;
	
	/**
	*	@var array An array of quailReportItem objects
	*/
	var $report;
	
	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	/**
	*	@var array An array of all the extensions that are images
	*/
	var $image_extensions = array('gif', 'jpg', 'png', 'jpeg', 'tiff', 'svn');
	
	/**
	*	The class constructor. We pass items by reference so we can alter the DOM if necessary
	*	@param object $dom The DOMDocument object 
	*	@param object $css The QuailCSS object
	*	@param array $path The path of this request
	*/
	function __construct(&$dom, &$css, &$path) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->report = array();
		$this->check();
	}
	
	/**
	*	Helper method to collect the report from this test. Some
	*	tests do additional cleanup by overriding this method
	*	@return array An array of QuailReportItem objects
	*/
	function getReport() {
		$this->report['severity'] = $this->default_severity;
		return $this->report;
	}
	
	/**
	*	Returns the default severity of the test
	*	@return int The severity level
	*/
	function getSeverity() {
		return $this->default_severity;
	}	
	/**
	*	Adds a new QuailReportItem to this current tests collection of reports.
	*	Most reports pertain to a particular element (like an IMG with no Alt attribute); 
	*	however, some are document-level and just either pass or don't pass
	*	@param object $element The DOMElement object that pertains to this report
	*	@param string $message An additional message to add to the report
	*	@param bool $pass Whether or not this report passed
	*/
	function addReport($element = null, $message = null, $pass = null) {
		$report = new quailReportItem();
		if($element)
			$report->element = $element;
		if($error)
			$report->message = $message;
		if(!is_null($pass))
			$report->pass = $pass;
		$this->report[] = $report;
	}
	
	/**
	*	Retrieves the full path for a file.
	*	@param string $file The path to a file
	*	@return string The absolute path to the file.
	*/	
	function getPath($file) {
		if(substr($file, 0, 7) == 'http://')
			return $file;
		$file = explode('/', $file);
		if(count($file) == 1)
			return implode('/', $this->path) .'/'. $file[0];
		
		$path = $this->path;
		foreach($file as $directory) {
			if($directory == '..') 
				array_pop($path);
			else
				$file_path[] = $directory;
		}

			return implode('/', $path) .'/'. implode('/', $file_path);

	}	
	
	/**
	*	Helper method to find all the elements that fit a particular query
	*	in the document (either by tag name, or by attributes from the htmlElements object)
	*	@param mixed $tags Either a single tag name in a string, or an array of tag names
	*	@param string $options The kind of option to select an element by (see htmlElements)
	*	@param string $value The value of the above option
	*	@return array An array of elements that fit the description
	*/
	function getAllElements($tags = null, $options = false, $value = true) {
		if(!is_array($tags))
			$tags = array($tags);
		if($options !== false)
			$tags = htmlElements::getElementsByOption($options, $value);
		$result = array();
		
		if(!is_array($tags))
			return array();
		foreach($tags as $tag) {
			$elements = $this->dom->getElementsByTagName($tag);
			if($elements) {
				foreach($elements as $element) {
					$result[] = $element;
				}
			}
		}
		if(count($result) == 0)
			return array();
		return $result;
	}
	
	/**
	*	Returns true if an element has a child with a given tag name
	*	@param object $element A DOMElement object
	*	@param string $child_tag The tag name of the child to find
	*	@return bool TRUE if the element does have a child with 
	*				 the given tag name, otherwise FALSE
	*/
	function elementHasChild($element, $child_tag) {
		foreach($element->childNodes as $child) {
			if($child->tagName == $child_tag)
				return true;
		}
		return false;
	}
	
	/**
	*	Finds all the elements with a given tag name that has
	*	an attribute
	*	@param string $tag The tag name to search for
	*	@param string $attribute The attribute to search on
	*	@param bool $unique Whether we only want one result per attribute
	*	@return array An array of DOMElements with the attribute
	*			      value as the key. 
	*
	*/
	function getElementsByAttribute($tag, $attribute, $unique = false) {
		foreach($this->getAllElements($tag) as $element) {
			if($element->hasAttribute($attribute)) {
				if($unique)
					$results[$element->getAttribute($attribute)] = $element;
				else
					$results[$element->getAttribute($attribute)][] = $element;	
			}
		}
		return $results;
	}
	
	/**
	*	Returns the next element after the current one.
	*	@param object $element A DOMElement object
	*	@return mixed FALSE if there is no other element, or a DOMElement object
	*/
	function getNextElement($element) {
		$parent = $element->parentNode;
		
		foreach($parent->childNodes as $child) {
			if($next)
				return $child;
			if($child->isSameNode($element))
				$next = true;
			
		}
		return false;
	}
	
	/**
	*	Returns the parent of an elment that has a given tag Name, but
	*	stops the search if it hits the $limiter tag
	*	@param object $element The DOMElement object to search on
	*	@param string $tag_name The name of the tag of the parent to find
	*	@param string $limiter The tag name of the element to stop searching on
	*				  regardless of the results (like search for a parent "P" tag
	*				  of this node but stop if you reach "body")
	*	@return mixed FALSE if no parent is found, or the DOMElement object of the found parent
	*/
	function getParent($element, $tag_name, $limiter) {
		while($element) {
			if($element->tagName == $tag_name)
				return $element;
			if($element->tagName == $limiter)
				return false;
			$element = $element->parentNode;
		}
		return false;
	}
}

/**
*	A special base class for tests that only file a report whenever
*	it hits the specified tag regardless of anything about the element
*	(especially for tests like "No Blink Tag" - or ones that fire on 
*	objects that require human attention). To use this class, just override
*	the value of the $tag variable.
*	
*/
class quailTagTest extends quailTest { 
	
	/**
	*	@var string The tag name of this test
	*/
	var $tag = '';
	
	/**
	*	Shouldn't need to be overridden. We just file one report item for every
	*	element we find with this class's $tag var.
	*/
	function check() {
		foreach($this->getAllElements($this->tag) as $element) {
			$this->addReport($element);
		}
	}
}

/**
*	Special base test class that deals with tests concerning the logical heirarchy
*	of headers. To use it, just extend and change the $tag var.
*/
class quailHeaderTest extends quailTest {
	
	/**
	* @var string The header tag this test applies to.
	*/
	var $tag = '';
	
	/**
	*	@var array An array of all the header tags
	*/
	var $headers = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
	
	/**
	*	The check method gathers all the headers together and walks through them, making sure that
	*	the logical display of headers makes sense.
	*/
	function check() {
		$tag_number = substr($this->tag, -1, 1);
		$doc_headers = array();
		$first_header = $this->dom->getElementsByTagName($this->tag);
		if($first_header->item(0)) {
			$current = $first_header->item(0);
			$previous_number = intval(substr($current->tagName, -1, 1));
			while($current) {
				
				if(in_array($current->tagName, $this->headers)) {
					$current_number = intval(substr($current->tagName, -1, 1));
					if($current_number > ($previous_number + 1))
						$this->addReport($current);
					$previous_number = intval(substr($current->tagName, -1, 1));
				}
				$current = $current->nextSibling;

			}
		
		}
		
	}
}

/**
*	Special base class which provides helper methods for tables.
*/
class quailTableTest extends quailTest {
	
	/**
	*	Takes the element object of a main table and returns the number
	*	of rows and columns in it.
	*	@param object The DOMElement of the main table tag
	*	@return array An array with the 'rows' value showing 
	*	the number of rows, and columsn showing the number of columns
	*/
	function getTable($table) {
		$rows = 0;
		$columns = 0;
		$first_row = true;
		if($table->tagName != 'table')
			return false;
		foreach($table->childNodes as $child) {
			if($child->tagName == 'tr') {
				$rows++;
				if($first_row) {
					foreach($child->childNodes as $column_child) {
						if($column_child->tagName == 'th' || $column_child->tagName == 'td')
							$columns++; 
					}				
					$first_row = false;
				}	
			}
		}
		
		return array('rows' => $rows, 'columns' => $columns);
	}
	
	/**
	*	Finds whether or not the table is a data table. Checks that the
	*	table has a logical order and uses 'th' or 'thead' tags to illustrate
	*	the page author thought it was a data table.
	*	@param object $table The DOMElement object of the table tag
	*	@return bool TRUE if the element is a data table, otherwise false
	*/
	function isData($table) {
		if($table->tagName != 'table') 
			return false;
		foreach($table->childNodes as $child) {
			if($child->tagName == 'tr') {
				foreach($child->childNodes as $row_child) {
					if($row_child->tagName == 'th')
						return true;
				}
			}
			if($child->tagName == 'thead')
				return true;
		}
		return false;
	}
	
}

/**
*	Base test class for tests which checks that the given input tag
*	has an associated lable tag.
*	To override, just override the tag and type variables, and use $no_type = true if it is a special
*	form tag like textarea.
*/
class inputHasLabel extends quailTest {
	
	/**
	*	@var string The tag name that this test applies to
	*/
	var $tag = 'input';
	
	/**
	*	@var string The type of input tag this is
	*/
	var $type = 'text';
	
	/**
	*	@var bool Wehether or not we should check the type attribute of the input tags
	*/
	var $no_type = false;
	
	/**
	*	Iterate through all the elemetns using the $tag tagname and the $type attribute (if appropriate)
	*	and then check it against a list of all LABEL tags.
	*/
	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($label->hasAttribute('for'))
				$labels[$label->getAttribute('for')] = $label;
			else {
				foreach($label->childNodes as $child) {
					if($child->tagName == $this->tag && ($child->getAttribute('type') == $this->type || $this->no_type))
						$input_in_label[$child->getAttribute('name')] = $child;
				}
			}
		}
		foreach($this->getAllElements($this->tag) as $input) {
			if($input->getAttribute('type') == $this->type || $this->no_type) {
				if(!$input->hasAttribute('title')) {
					if(!$input_in_label[$input->getAttribute('name')]) {
						if(!$labels[$input->getAttribute('id')] || trim($labels[$input->getAttribute('id')]->nodeValue) == '')
							$this->addReport($input);
					}
				
				}
			}
		}
	}

}

/**
*	Helper base class to check that input tags have an appropriate tab order
*/
class inputTabIndex extends quailTest {
	
	/**
	*	@var string The tag name that this test applies to
	*/
	var $tag;
	
	/**
	*	@var string The type of input tag this is
	*/
	var $type;
	
	/**
	*	@var bool Wehether or not we should check the type attribute of the input tags
	*/
	var $no_type = false;
	
	/**
	*	Iterate through all the input items and make sure the tabindex exists
	*	and is numeric.
	*/
	function check() {
		foreach($this->getAllElements($this->tag) as $element) {
			if(($no_type || $element->getAttribute('type') == $this->type)
					&& (!($element->hasAttribute('tabindex'))
						 || !is_numeric($element->getAttribute('tabindex')))) 
				$this->addReport($element);
		}
	}
}

/**
*	Helper test base for tests dealing with color difference and luminosity.
*/
class quailColorTest extends quailTest {
	
	/**
	*	Helper method that finds the luminosity between the provided
	*	foreground and background parameters.
	*	@param string $foreground The HEX value of the foreground color
	*	@param string $background The HEX value of the background color
	*	@return float The luminosity contrast ratio between the colors
	*/
	function getLuminosity($foreground, $background) {
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		return $this->luminosity($fore_rgb['r'], $back_rgb['r'],
							    $fore_rgb['g'], $back_rgb['g'],
							    $fore_rgb['b'], $back_rgb['b']);
	}
	
	/**
	*	Returns the luminosity between two colors
	*	@param string $r The first Red value
	*	@param string $r2 The second Red value
	*	@param string $g The first Green value
	*	@param string $g2 The second Green value
	*	@param string $b The first Blue value
	*	@param string $b2 The second Blue value
	*	@return float The luminosity contrast ratio between the colors
	*/
	function luminosity($r,$r2,$g,$g2,$b,$b2) {
		$RsRGB = $r/255;
		$GsRGB = $g/255;
		$BsRGB = $b/255;
		$R = ($RsRGB <= 0.03928) ? $RsRGB/12.92 : pow(($RsRGB+0.055)/1.055, 2.4);
		$G = ($GsRGB <= 0.03928) ? $GsRGB/12.92 : pow(($GsRGB+0.055)/1.055, 2.4);
		$B = ($BsRGB <= 0.03928) ? $BsRGB/12.92 : pow(($BsRGB+0.055)/1.055, 2.4);
	
		$RsRGB2 = $r2/255;
		$GsRGB2 = $g2/255;
		$BsRGB2 = $b2/255;
		$R2 = ($RsRGB2 <= 0.03928) ? $RsRGB2/12.92 : pow(($RsRGB2+0.055)/1.055, 2.4);
		$G2 = ($GsRGB2 <= 0.03928) ? $GsRGB2/12.92 : pow(($GsRGB2+0.055)/1.055, 2.4);
		$B2 = ($BsRGB2 <= 0.03928) ? $BsRGB2/12.92 : pow(($BsRGB2+0.055)/1.055, 2.4);
	
		if ($r+$g+$b <= $r2+$g2+$b2) {
		$l2 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l1 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		} else {
		$l1 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l2 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
		}
		
		$luminosity = round(($l1 + 0.05)/($l2 + 0.05),2);
		return $luminosity;
	}


	/**
	*	Returns the decimal equivalents for a HEX color
	*	@param string $color The hex color value
	*	@return array An array where 'r' is the Red value, 'g' is Green, and 'b' is Blue
	*/
	function getRGB($color) {
		$color = str_replace('#', '', $color);
		$c = str_split($color, 2);
		$results = array('r' => hexdec($c[0]), 'g' => hexdec($c[1]), 'b' => hexdec($c[2]));
		return $results;
	}
	
	/**
	*	Returns the WAIERT contrast between two colors
	*	@see GetLuminosity	
	*/
	function getWaiErtContrast($foreground, $background) {
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		$diffs = $this->getWaiDiffs($fore_rgb, $back_rgb);
		
		return $diffs['red'] + $diffs['green'] + $diffs['blue'];
	}
	
	/**
	*	Returns the WAI ERT Brightness between two colors
	*	
	*/
	function getWaiErtBrightness($foreground, $background) {
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		$color = $this->getWaiDiffs($fore_rgb, $back_rgb);
		return (($color['red'] * 299) + ($color['green'] * 587) + ($color['blue'] * 114)) / 1000;
	}
	
	function getWaiDiffs($fore_rgb, $back_rgb) {
		$red_diff = ($fore_rgb['r'] > $back_rgb['r']) 
						? $fore_rgb['r'] - $back_rgb['r'] 
						: $back_rgb['r'] - $fore_rgb['r'];
		$green_diff = ($fore_rgb['g'] > $back_rgb['g']) 
						? $fore_rgb['g'] - $back_rgb['g'] 
						: $back_rgb['g'] - $fore_rgb['g'];		

		$blue_diff = ($fore_rgb['b'] > $back_rgb['b']) 
						? $fore_rgb['b'] - $back_rgb['b'] 
						: $back_rgb['b'] - $fore_rgb['b'];
		return array('red' => $red_diff, 'green' => $green_diff, 'blue' => $blue_diff);
	}
}

/**
*	Base class for test dealing with WAI ERT color contrast for the document
*	Because a lot of the tests deal with text, vlink, alink, etc.
*/
class bodyWaiErtColorContrast extends quailColorTest {

	/**
	*	@var string The attribute to check for the background color of the <body> tag
	*/
	var $background = 'bgcolor';

	/**
	*	@var string The attribute to check for the foreground color of the <body> tag
	*/
	var $foreground = 'text';
	
	/**
	*	Compares the WAI ERT contrast on the given color attributes of the <body> tag
	*/
	function check() {
		$body = $this->getAllElements('body');
		if(!$body)
			return false;
		$body = $body[0];
		if($body->hasAttribute($this->foreground) && $body->hasAttribute($this->background))
			if( $this->getWaiErtContrast($body->getAttribute($this->foreground), $body->getAttribute($this->background)) < 500)
				$this->addReport(null, null, false);
			elseif($this->getWaiErtBrightness($body->getAttribute($this->foreground), $body->getAttribute($this->background)) < 125)
				$this->addReport(null, null, false);
			
	}

}

/**
*	Helper function to support checking the varous color attributes of the <body> tag
*	against WCAG standards
*/
class bodyColorContrast extends quailColorTest {
	
	/**
	*	@var string The attribute to check for the background color of the <body> tag
	*/
	var $background = 'bgcolor';

	/**
	*	@var string The attribute to check for the foreground color of the <body> tag
	*/
	var $foreground = 'text';
	
	/**
	*	Compares the WCAG contrast on the given color attributes of the <body> tag
	*/
	function check() {
		$body = $this->getAllElements('body');
		if(!$body)
			return false;
		$body = $body[0];
		if($body->hasAttribute($this->foreground) && $body->hasAttribute($this->background))
			if( $this->getLuminosity($body->getAttribute($this->foreground), $body->getAttribute($this->background)) < 5)
				$this->addReport(null, null, false);
	}
}