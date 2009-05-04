<?php 

define(QUAIL_PATH, '/usr/web/access/quail/');

foreach (glob(QUAIL_PATH."common/*.php") as $filename) {
	require_once($filename);
}

class quail {

	var $dom;
	
	var $type;
	
	var $uri;
	
	var $domain;
	
	var $guideline_name = 'wcag';
	
	var $reporter_name = 'static';
	
	var $reporter;
	
	var $guideline;
	
	var $base_url;
	
	var $path = array();
	
	var $cms_mode = false;
	
	var $css_files;
	
	var $css;
	
	function __construct($value, $guideline = 'wcag', $type = 'string', $reporter = 'static', $domain = 'en') {
		$this->dom = new DOMDocument();
		$this->type = $type;
		$this->uri = $value;
		$this->domain = $domain;
		$this->guideline_name = $guideline;
		$this->reporter_name = $reporter;
		switch($type) {
			case 'string':
				@$this->dom->loadHTML($value);
				break;
			case 'file':
				@$this->dom->loadHTMLFile($value);
				break;
			case 'uri':
				@$this->dom->loadHTML(file_get_contents($value));
				break;
		}
		$this->prepareBaseUrl($value, $type);
		$this->loadImageLibrary();

	}
	
	function __set($var, $value) {
		$this->$var = $value;
	}
	
	function __get($var) {
		$this->$var = $var;
	}
	
	function prepareBaseUrl($value, $type) {
		if($type == 'file') {
			$path = explode('/', $value);
			array_pop($path);
			$this->path = $path;
		}
		if($type == 'uri') {
			$parts = explode('://', $value);
			$this->path[] = $parts[0] .':/';
			if(is_array($parts[1])) {
				foreach(explode('/', $this->getBaseFromFile($parts[1])) as $part) {
					$this->path[] = $part;
				}
			}
			else { 
				$this->path[] = $parts[1] .'/';
			}
		}
	}
	
	 function getBaseFromFile($file) {  
		 $find = '/';  
		 $after_find = substr(strrchr($file, $find), 1);  
		 $strlen_str = strlen($after_find);  
		 $result = substr($file, 0, -$strlen_str);  
		 return $result;  
	 }
	
	function loadImageLibrary() {
		if(function_exists('gd_info')) {
			require_once('lib/wideimage/WideImage.inc.php');
			define('IMAGECLASS_EXISTS', true);
		}
		else
			define('IMAGECLASS_EXISTS', false);
	}
	
	function addCSS($css) {
		$this->css_files[] = $css;
	}
	
	function getError($error) {
		return $this->reporter->getError($error);
	}
	
	function loadReporter() {
		require_once('reporters/reporter.'. $this->reporter_name .'.php');
		$classname = 'report'.ucfirst($this->reporter_name);
		$this->reporter = new $classname($this->dom, $this->css, $this->guideline, $this->domain, $this->path);
	}
	
	function getTechnique($type, $technique) {
		return $this->guideline->getTechnique($type, $technique);
	}
	
	function isValid() {
		if(!$this->dom)
			return false;
		return true;
	}
	
	function runCheck() {
		if(!$this->isValid())
			return false;
		$this->getCSSObject();
		require_once('guidelines/'. $this->guideline_name .'.php');
		$classname = ucfirst(strtolower($this->guideline_name)).'Guideline';
		$this->guideline = new $classname($this->dom, $this->css, $this->path);
	}
	
	function getCSSObject() {
		if(!$this->cms_mode)
			$this->css = new quailCSS($this->dom, $this->uri, $this->type);
	}
	
	function getReport() {
		if(!$this->reporter)
			$this->loadReporter();
		return $this->reporter->getReport();
	}
	
	function getTest($test) {
		$test_class = new $test($this->dom, $this->css, $this->path);
		return $test_class->report;
	}
	
	function getReportOnCheckpoint($guideline, $checkpoint) {
		return $this->guideline->getReport($guideline, $checkpoint);
	}
	

}

class quailCSS {
	
	var $dom;
	
	var $uri;
	
	var $index;
	
	var $type;
	
	var $css;
	
	var $css_string;
	
	var $cms_mode;
	
	function __construct($dom, $uri, $type, $cms_mode = false, $css_files = array()) {
		$this->dom = $dom;
		$this->type = $type;
		$this->cms_mode = $cms_mode;
		$this->css_files = $css_files;
		$this->loadCSS();
	}
	
	function loadCSS() {
		if($this->cms_mode) {
			$css = $this->css_files;
		}
		else {
			$style_sheets = $this->dom->getElementsByTagName('link');
			
			foreach($style_sheets as $style) {
				if($style->getAttribute('rel') == 'stylesheet' &&
					$style->getAttribute('media') != 'print') {
					$css[] = $style->getAttribute('href');
				}
			}
		}
		if(is_array($css)) {
			foreach($css as $sheet) {
				if($this->type == 'uri')
					$this->loadUri($sheet);
			}
			$this->formatCSS();
		}
	}
	
	function loadUri($rel) {
		
		if(strpos($rel, 'http://') !== false || strpos($rel, 'https://') !== false)
			$uri = $rel;
		else
			$uri = substr($this->uri, 0, strrpos($this->uri, '/')) .$rel;
			
		$this->css_string .= file_get_contents($uri);
	}
	
	function getStyle($element) {
		$result_class = $this->getElementStyle($element, 'elements');
		$result_class = $this->getElementStyle($element, 'class', $result_class);
		return $this->getElementStyle($element, 'id', $result_class);
	}
	
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

class quailReporter {

	var $dom;
	
	var $css;
	
	var $translation_file;
	
	var $report;
	
	var $path;
	
	var $absolute_attributes = array('src', 'href');
	
	function __construct(&$dom, &$css, &$guideline, $domain, $path = '') {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->guideline = $guideline;
		$this->loadTranslationFile($domain);
	}
	
	function loadTranslationFile($domain) {
		$translations = file(QUAIL_PATH.'reporters/translations/'. $domain .'.php');
		foreach($translations as $translation) {
			$ex = explode("\t", $translation);
			if($ex[0]) {
				$this->translation[$ex[0]] = $ex[1];
			}
		}
	}
	
	function setAbsolutePath(&$element) {
		foreach($this->absolute_attributes as $attribute) {
			if($element->hasAttribute($attribute)) 
				$attr = $attribute;
		}
		
		if($attr) {
			$item = $element->getAttribute($attr);
			//We are ignoring items with absolute URLs
			if(strpos($item, '://') === false) {
				
				$item = implode('/', $this->path) . ltrim($item, '/');
				$element->setAttribute($attr, $item);
				print $item .'<br>';
			}
		}
		if($element->tagName == 'style') {
			if(strpos($element->nodeValue, '@import') !== false) {
				
			
			}
		}
	}
	
}

class quailReportItem {
	
	var $element;

	var $message;
	
	var $manual;
	
	var $pass;

	function getHTML($extra_attributes = array()) {
		
		$result_dom = new DOMDocument();
		try {
			$result_element = $result_dom->createElement($this->element->tagName);
		}
		catch (Exception $e) {
			return false;
		}
		foreach($this->element->attributes as $attribute) {
			$result_element->setAttribute($attribute->name, $attribute->value);
		}
		foreach($extra_attributes as $name => $value) {
			$result_element->setAttribute($name, $value);
		}
		$result_element->nodeValue = $this->element->nodeValue;
		$result_dom->appendChild($result_element);
		return $result_dom->saveHTML();
	
	}
	
}


class quailGuideline {
	
	var $dom;
	
	var $css;
	
	var $path;
	
	var $report;
	
	function __construct(&$dom, &$css, &$path) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->run();
	}
	
	function run() {
		foreach($this->tests as $test) {
			require_once('common/tests/'.$test.'.php');
			$$test = new $test($this->dom, $this->css, $this->path);
			$this->report[$test] = $$test->getReport();
		}
	}
	
	function getReport(){
		return $this->report;
	}
}