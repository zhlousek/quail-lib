<?php 

define(QUAIL_PATH, '/usr/web/access/quail/');

/**
*	@var int A severe failure
*/	
define(QUAIL_TEST_SEVERE, 1);
define(QUAIL_TEST_MODERATE, 2);
define(QUAIL_TEST_SUGGESTION, 3);

foreach (glob(QUAIL_PATH."common/*.php") as $filename) {
	require_once($filename);
}

/**
*	The main interface class for quail. 
*
*/
class quail {
	/**
	*	@var object The central QUAIL DOMDocument object
	*/
	var $dom;
	
	/**
	*	@var string The type of request this is (either 'string', 'file', or 'uri'
	*/
	var $type;
	
	/**
	*	@var string The base URI of the current request (used to rebuild page if necessary)
	*/	
	var $uri;
	
	/**
	*	@var string The translation domain of the currnet library
	*/
	var $domain;
	
	/**
	*	@var string The name of the guideline
	*/
	var $guideline_name = 'wcag';
	
	/**
	*	@var string The name of the reporter to use
	*/
	var $reporter_name = 'static';
	
	/**
	*	@var object A QUAIL reporting object
	*/	
	var $reporter;
	
	/**
	*	@var object The central guideline object
	*/
	var $guideline;
	
	/**
	*	@var string The base URL for any request of type URI
	*/
	var $base_url;
	
	/**
	*	@var array An array of the current file or URI path
	*/
	var $path = array();
	
	/**
	*	@var bool Whether the library should run in CMS mode (used to disable tests that only work on a document-level)
	*/
	var $cms_mode = false;
	
	/**
	*	@var array An array of additional CSS files to load (useful for CMS content)
	*/
	var $css_files;
	
	/**
	*	@var object The QuailCSS object
	*/
	var $css;
	
	/**
	*	The class constructor
	*	@param string $value Either the HTML string to check or the file/uri of the request
	*	@param string $guideline The name of the guideline
	*	@param string $type The type of the request (either file, uri, or string)
	*	@param string $reporter The name of the reporter to use
	*	@param string $domain The domain of the translation language to use
	*/
	function __construct($value, $guideline = 'wcag', $type = 'string', $reporter = 'static', $domain = 'en') {
		$this->dom = new DOMDocument();
		//$this->dom->registerNodeClass('DOMElement', 'QuailDOMElement');
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
	
	
	/**
	*	Formats the base URL for either a file or uri request. We are essentially
	*	formatting a base url for future reporters to use to find CSS files or
	*	for tests that use external resources (images, objects, etc) to run tests on them.
	*	@param string $value The path value 
	*	@param string $type The type of request 
	*/
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
	
	/**
	*	Retrieves the absolute path to a file
	*	@param string $file The path to a file
	*	@return string The absolute path to a file
	*/
	 function getBaseFromFile($file) {  
		 $find = '/';  
		 $after_find = substr(strrchr($file, $find), 1);  
		 $strlen_str = strlen($after_find);  
		 $result = substr($file, 0, -$strlen_str);  
		 return $result;  
	 }
	
	/**
	*	Loads a copy of the WideImage library and sets using a global var
	*	to see if the class is available or not.
	*/
	function loadImageLibrary() {
		if(function_exists('gd_info')) {
			require_once('lib/wideimage/WideImage.inc.php');
			define('IMAGECLASS_EXISTS', true);
		}
		else
			define('IMAGECLASS_EXISTS', false);
	}
	
	/**
	*	Helper method to add an additional CSS file
	*	@param string $css The URI or file path to a CSS file
	*/
	function addCSS($css) {
		$this->css_files[] = $css;
	}
	
	/**
	*	Retrives a single error from the current reporter
	*	@param string $error The error key
	*	@return object A QuailReportItem object
	*/
	function getError($error) {
		return $this->reporter->getError($error);
	}
	
	/**
	*	A local method to load the required file for a reporter and set it for the current QUAIL object
	*	@param array $options An array of options for the reporter
	*/
	function loadReporter($options = array()) {
		require_once('reporters/reporter.'. $this->reporter_name .'.php');
		$classname = 'report'.ucfirst($this->reporter_name);
		$this->reporter = new $classname($this->dom, $this->css, $this->guideline, $this->domain, $this->path);
		if(count($options))
			$this->reporter->setOptions($options);
	}
	

	/**
	*	Checks that the DOM object is valid or not
	*	@return bool Whether the DOMDocument is valid
	*/
	function isValid() {
		if(!$this->dom)
			return false;
		return true;
	}
	
	
	/**
	*	Starts running automated checks. Loads the CSS file parser
	*	and the guideline object.
	*/
	function runCheck($options = null) {
		if(!$this->isValid())
			return false;
		$this->getCSSObject();
		$classname = ucfirst(strtolower($this->guideline_name)).'Guideline';
		if(!class_exists($classname)) {		
			require_once('guidelines/'. $this->guideline_name .'.php');
		}
		$this->guideline = new $classname($this->dom, $this->css, $this->path, $options);
	}
	
	/**
	*	Loads the quailCSS object
	*/
	function getCSSObject() {
		if(!$this->cms_mode)
			$this->css = new quailCSS($this->dom, $this->uri, $this->type);
	}
	
	/**
	*	Returns a formatted report from the current reporter.
	*	@param array $options An array of all the options
	*	@return mixed See the documentation on your reporter's getReport method.
	*/
	function getReport($options = array()) {
		if(!$this->reporter)
			$this->loadReporter($options);
		if($options) {
			$this->reporter->setOptions($options);
		}
		return $this->reporter->getReport();
	}
	
	/**
	*	Runs one test on the current DOMDocument
	*	@pararm string $test The name of the test to run
	*	@reutrn object The QuailReportItem returned from the test
	*/
	function getTest($test) {
		require_once('common/tests/'. $test .'.php');
		$test_class = new $test($this->dom, $this->css, $this->path);
		return $test_class->report;
	}
	
	/**
	*	Retrieves the default severity of a test
	*	@pararm string $test The name of the test to run
	*	@reutrn object The severity level of the test
	*/
	function getTestSeverity($test) {
		require_once('common/tests/'. $test .'.php');
		$test_class = new $test($this->dom, $this->css, $this->path);
		return $test_class->getSeverity();
	}
	

}

/**
*	The base classe for a reporter
*/
class quailReporter {
	
	/**
	*	@var object The current document's DOMDocument
	*/
	var $dom;
	
	/**
	*	@var object The current quailCSS object
	*/
	var $css;
	
	/**
	*	@var array An array of test names and the translation for the problems with it
	*/
	var $translation;
	
	/**
	*	@var array A collection of quailReportItem objects
	*/
	var $report;
	
	/**
	*	@var array The path to the current document
	*/
	var $path;
	
	/**
	*	@var object Additional options for this reporter
	*/
	var $options;
	
	/**
	*	@var array An array of attributes to search for to turn into absolute paths rather than
	*			   relative paths
	*/
	var $absolute_attributes = array('src', 'href');
	
	/**
	*	The class constructor
	*	@param object $dom The current DOMDocument object
	*	@param object $css The current QuailCSS object
	*	@param object $guideline The current guideline object
	*	@param string $domain The current translation domain
	*	@param string $path The current path
	*/
	function __construct(&$dom, &$css, &$guideline, $domain, $path = '') {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->options = new stdClass;
		$this->guideline = $guideline;
		$this->loadTranslationFile($domain);
	}
	
	/**
	*	Finds the translation file and loads it into the local translation array
	*	@param string $domain The translation domain
	*/
	function loadTranslationFile($domain) {
		$translations = file(QUAIL_PATH.'reporters/translations/'. $domain .'.php');
		foreach($translations as $translation) {
			$ex = explode("\t", $translation);
			if($ex[0]) {
				$this->translation[trim($ex[0])] = trim($ex[1]);
			}
		}
	}
	
	/**
	*	Sets options for the reporter
	*	@param array $options an array of options
	*/
	function setOptions($options) {
		foreach($options as $key => $value) {
			$this->options->$key = $value;
		}
	}
	
	/**
	*	Sets the absolute path for an element
	*	@param object $element A DOMElement object to turn into an absolute path
	*/
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
				
			}
		}
		if($element->tagName == 'style') {
			if(strpos($element->nodeValue, '@import') !== false) {
				
			
			}
		}
	}
	
}

/**
*	A report item. There is one per issue with the report
*
*/
class quailReportItem {
	
	/**
	*	@var object The DOMElement that the report item refers to (if any)
	*/
	var $element;
	
	/**
	*	@var string The error message
	*/
	var $message;
	
	/**
	*	@var bool Whether the check needs to be manually verified
	*/
	var $manual;
	
	/**
	*	@var bool For document-level tests, this says whether the test passed or not
	*/
	var $pass;
	
	function getLine() {
		if(is_object($this->element) && method_exists($this->element, 'getLineNo')) {
			return $this->element->getLineNo();
		}
		return 0;
	}
	
	/**
	*	Returns the current element in plain HTML form
	*	@param array $extra_attributes An array of extra attributes to add to the element
	*	@return string An HTML string version of the provided DOMElement object
	*/
	function getHTML($extra_attributes = array()) {
		if(!$this->element)
			return '';
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
		$result_element->nodeValue = htmlentities($this->element->nodeValue);
		$result_dom->appendChild($result_element);
		return $result_dom->saveHTML();
	
	}
	
}

/**
*	The base class for a guideline
*
*/
class quailGuideline {
	
	/**
	*	@var object The current document's DOMDocument
	*/
	var $dom;
	
	/**
	*	@var object The current quailCSS object
	*/
	var $css;
	
	/**
	*	@var array The path to the current document
	*/
	var $path;

	/**
	*	@var array An array of report objects
	*/
	var $report;
	
	/**
	*	The class constructor
	*	@param object $dom The current DOMDocument object
	*	@param object $css The current QuailCSS object
	*	@param string $path The current path
	*/

	function __construct(&$dom, &$css, &$path, $arg = null) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->run($arg);
	}
	
	/**
	*	Iteates through each test string, makes a new test object, and runs it against the current DOM
	*/
	function run($arg = null) {
		foreach($this->tests as $testname => $options) {
			require_once('common/tests/'.$testname.'.php');
			$$testname = new $testname($this->dom, $this->css, $this->path);
			$this->report[$testname] = $$testname->getReport();	
		}
	}
	
	/**
	*	Returns all the Report variable
	*	@reutrn mixed Look to your report to see what it returns
	*/
	function getReport(){
		return $this->report;
	}
	
	/**
	*	Returns the severity level of a given test
	*	@param string $testname The name of the test
	*	@return int The severity level
	*/
	function getSeverity($testname) {
		return $this->tests[$testname]['severity'];
	}
}