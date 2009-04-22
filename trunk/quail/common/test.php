<?php


foreach (glob(QUAIL_PATH."common/tests/*.php") as $filename) {
	require_once($filename);
}

class quailTest {

	var $dom;
	
	var $css;
	
	var $path;
	
	var $base_path;
	
	var $report;
	
	var $image_extensions = array('gif', 'jpg', 'png', 'jpeg', 'tiff', 'svn');
	
	function __construct(&$dom, &$css, &$path) {
		$this->dom = $dom;
		$this->css = $css;
		$this->path = $path;
		$this->report = array();
		$this->check();
	}
	
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
		return implode('/', $path) .'/'. implode('/'. $file_path);
		
	}	
	
	
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
	
	function elementHasChild($element, $child_tag) {
		foreach($element->childNodes as $child) {
			if($child->tagName == $child_tag)
				return true;
		}
		return false;
	}
	
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
	
	function getParent($element, $tagName, $limiter) {
		while($element) {
			if($element->tagName == $tagName)
				return $element;
			if($element->tagName == $limiter)
				return false;
			$element = $element->parentNode;
		}
		return false;
	}
}

class quailTagTest extends quailTest { 

	var $tag = '';
	
	function check() {
		foreach($this->getAllElements($this->tag) as $element) {
			$this->addReport($element);
		}
	}
}

class quailHeaderTest extends quailTest {

	var $tag = '';
	
	var $headers = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
	
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

class quailTableTest extends quailTest {
	
	function getTable($table) {
		$rows = 0;
		$columns = 0;
		$first_row = true;
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
	
	function isData($table) {
		foreach($table->childNodes as $child) {
			if($child->tagName == 'tr') {
				foreach($child->childNodes as $row_child) {
					if($row_child->tagName == 'th')
						return true;
				}
			}
		}
		return false;
	}
	
}

class inputHasLabel extends quailTest {
	
	var $tag = 'input';
	
	var $type = 'text';
	
	var $no_type = false;
	
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

class inputTabIndex extends quailTest {

	var $tag;
	
	var $type;
	
	var $no_type = false;
	
	function check() {
		foreach($this->getAllElements($this->tag) as $element) {
			if(($no_type || $element->getAttribute('type') == $this->type)
					&& (!($element->hasAttribute('tabindex'))
						 || !is_numeric($element->getAttribute('tabindex')))) 
				$this->addReport($element);
		}
	}
}


class quailColorTest extends quailTest {

	function getLuminosity($foreground, $background) {
		$fore_rgb = $this->getRGB($foreground);
		$back_rgb = $this->getRGB($background);
		return $this->luminosity($fore_rgb['r'], $back_rgb['r'],
							    $fore_rgb['g'], $back_rgb['g'],
							    $fore_rgb['b'], $back_rgb['b']);
	}
	
	
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


	
	function getRGB($color) {
		$color = str_replace('#', '', $color);
		$c = str_split($color, 2);
		$results = array('r' => hexdec($c[0]), 'g' => hexdec($c[1]), 'b' => hexdec($c[2]));
		return $results;
	}

}

class bodyColorContrast extends quailColorTest {
	
	var $background = 'bgcolor';
	var $foreground = 'text';
	
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