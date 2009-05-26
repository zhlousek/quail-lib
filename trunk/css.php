<?php

/**
*	A helper class to parse the document's CSS so we can run accessibility
*	tests against it.
*/
class quailCSS {
	
	/**
	*	@var object The DOMDocument object of the current document
	*/
	var $dom;
	
	/**
	*	@var string The URI of the current document
	*/
	var $uri;

	/**
	*	@var array An array of all the named elements in the CSS file so we can find them
	*/	
	var $index;
	
	/**
	*	@var string The type of request (inherited from the main QUAIL object)
	*/
	var $type;
	
	/**
	*	@var array An array of all the CSS elements and attributes
	*/
	var $css;
	
	/**
	*	@var string Additional CSS information (usually for CMS mode requests)
	*/
	var $css_string;
	
	/**
	*	@var bool Whether or not we are running in CMS mode
	*/
	var $cms_mode;
	
	/**
	*	Class constructor. We are just building and importing variables here and then loading the CSS
	*	@param object $dom The DOMDocument object
	*	@param string $uri The URI of the request
	*	@param string $type The type of request
	*	@param bool $cms_mode Whether we are running in CMS mode
	*	@param array $css_files An array of additional CSS files to load
	*/
	function __construct(&$dom, $uri, $type, $cms_mode = false, $css_files = array()) {
		$this->dom = $dom;
		$this->type = $type;
		$this->uri = $uri;
		$this->cms_mode = $cms_mode;
		$this->css_files = $css_files;
		$this->loadCSS();
		$this->addStylesToElements();
	}
	
	/**
	*	Loads all the CSS files from the document using LINK elements or @import commands
	*/
	function loadCSS() {
		if($this->cms_mode) {
			$css = $this->css_files;
		}
		else {
			$style_sheets = $this->dom->getElementsByTagName('link');
			
			foreach($style_sheets as $style) {
				
				if(strtolower($style->getAttribute('rel')) == 'stylesheet' &&
					$style->getAttribute('media') != 'print') {
						$css[] = $style->getAttribute('href');
				}
			}
		}
		if(is_array($css)) {
			foreach($css as $sheet) {
				if($this->type == 'uri')
					$this->loadUri($sheet);
				if($this->type == 'file') 
					$this->loadUri($sheet);
			}
			$this->formatCSS();
		}
	}
	
	/**
	*	Adds the inherited CSS styles to the style attributes of all elements
	*/
	function addStylesToElements() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			$style = $this->getStyle($element);
			if($style)
				$element->setCSS($style);
		}
	}
	
	/**
	*	Loads a CSS file from a URI
	*	@param string $rel The URI of the CSS file
	*/
	function loadUri($rel) {
		
		if(strpos($rel, 'http://') !== false || strpos($rel, 'https://') !== false)
			$uri = $rel;
		else
			$uri = substr($this->uri, 0, strrpos($this->uri, '/')) .'/'.$rel;
			
		$this->css_string .= @file_get_contents($uri);
	}
	
	/**
	*	Walks throught the index of CSS elemeents and returns all the applied styles
	*	of the provided element. We load the element-level, then class, then ID.
	*	@param object $element The DOMElement object
	*	@return array An associative array of all the styles which apply to the element
	*/
	function getStyle($element) {
		$result_class = $this->getElementStyle($element, 'elements');
		$result_class = $this->getElementStyle($element, 'class', $result_class);
		return $this->getElementStyle($element, 'id', $result_class);
	}
	
	/**
	*	Gets the style for a given element
	*	@param object The DOMElement object
	*	@param string $type The level of request this is (element, class, or ID)
	*	@param array $result Any additional styles to include in this request
	*	@return array An associative array of all the styles which apply to the element at the type-level
	*/
	function getElementStyle($element, $type = 'class', $result = array()) {
		if($element->getAttribute($type)) {
				$classes = explode(' ', $element->getAttribute($type));
				foreach($classes as $class) {
					if(is_array($this->css[$this->index[$type]['element style'][$class]])) {
						foreach($this->css[$this->index[$type]['element style'][$class]] as $key => $value) {
							$result[$key] = $value;
						}	
					}
					if(is_array($this->css[$this->index[$type][$tagname][$class]])) {
						foreach($this->css[$this->index[$type][$tagname][$class]] as $key => $value) {
							$result[$key] = $value;
						}
					}
				}
		}
		if($type = 'element') {
			$codes = explode(";",$element->getAttribute('style'));
			if(count($codes) > 0) {
				foreach($codes as $code) {
					$code = trim($code);
					list($codekey, $codevalue) = explode(":",$code,2);
					if(strlen($codekey) > 0) {
						$result[trim($codekey)] = trim($codevalue);
					}
				}
			}
		}
		return $result;
	}
	
	/**
	*	Adds a CSS element to the current index
	*	@param string $key The CSS key for the element
	*	@param string $codestr The styles for the CSS Element
	*/
	function addElement($key, $codestr) {
		$key = strtolower($key);
		$codestr = strtolower($codestr);
		if(!isset($this->css[$key])) {
			$this->css[$key] = array();
		}
		$codes = explode(";",$codestr);
		if(count($codes) > 0) {
			foreach($codes as $code) {
				$code = trim($code);
				list($codekey, $codevalue) = explode(":",$code,2);
				if(strlen($codekey) > 0) {
					$this->css[$key][trim($codekey)] = trim($codevalue);
					$this->addIndexEntry($key);
				}
			}
		}
	}
	
	/**
	*
	*
	*/
	function getAllValuesForCode($code) {
		$results = array();
		foreach($this->css as $selector => $css) {
			foreach($css as $css_code => $css_value) {
				if($css_code == $code)
					$results[$selector] = $css_value;
			}
		}
		return $results;
	}

	/**
	*	Adds an index entry for the given key
	*	@param string $key The CSS key
	*/	
	function addIndexEntry($key) {
		$keys = explode(' ', $key);
		$selector = array_pop($keys);
		if(strpos($selector, '#') !== false) {
			$sup = 'id';
			$parts = explode('#', $selector);
		}
		elseif(strpos($selector, '.') !== false) {
			$sup = 'class';
			$parts = explode('.', $selector);
		}
		else {
			$sup = 'elements';
			$parts = array($selector);
		}
		if(!$parts[0])
			$parts[0] = 'element style';
		if($parts[1])
			$this->index[$sup][$parts[0]][$parts[1]] = $key;
		else 
			$this->index[$sup][$parts[0]]['element style'] = $key;
	}

	/**
	* 	Formats the CSS to be ready to import into an array of styles
	*	@return bool Whether there were elements imported or not
	*/	
	function formatCSS() {
		// Remove comments
		$str = preg_replace("/\/\*(.*)?\*\//Usi", "", $this->css_string);
		// Parse this damn csscode
		$parts = explode("}",$str);
		if(count($parts) > 0) {
			foreach($parts as $part) {
				list($keystr,$codestr) = explode("{",$part);
				$keys = explode(",",trim($keystr));
				if(count($keys) > 0) {
					foreach($keys as $key) {
						if(strlen($key) > 0) {
							$key = str_replace("\n", "", $key);
							$key = str_replace("\\", "", $key);
							$this->addElement($key, trim($codestr));
						}
					}
				}
			}
		}
		return (count($this->css) > 0);
	}
	
	
}
