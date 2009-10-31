<?php


class aAdjacentWithSameResourceShouldBeCombined extends quailTest {
	
	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(trim($a->nextSibling->wholeText) == '')
				$next = $a->nextSibling->nextSibling;
			else
				$next = $a->nextSibling;
			if($next->tagName == 'a') {
				if($a->getAttribute('href') == $next->getAttribute('href'))
					$this->addReport($a);
			}
		}
	}
}

class aImgAltNotRepetative extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;


	function check() {
		foreach($this->getAllElements('a') as $a) {
			foreach($a->childNodes as $child) {
				if($child->tagName == 'img') {
					if(trim($a->nodeValue) == trim($child->getAttribute('alt')))
						$this->addReport($child);
				}
			}
		}
	}
}

class aLinkTextDoesNotBeginWithRedundantWord extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $problem_words = array('link to', 'go to');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue) {
				if($a->firstChild->tagName == 'img') {
					$text = $a->firstChild->getAttribute('alt');
				}
			}
			else 
				$text = $a->nodeValue;
			foreach($this->problem_words as $word) {
				if(strpos(trim($text), $word) === 0)
					$this->addReport($a);
			}
		}
	}
}

class aLinksAreSeperatedByPrintableCharacters extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->nextSibling->nextSibling->tagName == 'a' && trim($a->nextSibling->wholeText) == '')
				$this->addReport($a);
		}
	}
}


class aLinksDontOpenNewWindow extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('target') 
				&& !in_array($a->getAttribute('target'), $this->allowed_targets)) {
					$this->addReport($a);
			}
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksMakeSenseOutOfContext extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(strlen($a->nodeValue) > 1)
				$this->addReport($a);
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksToMultiMediaRequireTranscript extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wmv', 'mpg', 'mov', 'ram', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$filename = explode('.', $a->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class aLinksToSoundFilesNeedTranscripts extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wav', 'snd', 'mp3', 'iff', 'svx', 'sam', 'smp', 'vce', 'vox', 'pcm', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$filename = explode('.', $a->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}

}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=145&lang=eng
*/


class aMultimediaTextAlternative extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wmv', 'wav',  'mpg', 'mov', 'ram', 'aif');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('href')) {
				$extension = substr($a->getAttribute('href'), 
							 (strrpos($a->getAttribute('href'), '.') + 1), 4);
				if(in_array($extension, $this->extensions))
					$this->addReport($a);
			}
		}
	}
}

class aMustContainText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if((!$a->nodeValue || trim(html_entity_decode($a->nodeValue)) == '')
				&& !$a->hasAttribute('title')) {
				$fail = true;
				$child = true;
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img' && trim($child->getAttribute('alt')) != '')
						$fail = false;
					if($child->nodeValue)
						$fail = false;
				}
				if($fail)
					$this->addReport($a);
			}
		}
	}
}

class aMustHaveTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}

class aMustNotHaveJavascriptHref extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(substr(trim($a->getAttribute('href')), 0, 11) == 'javascript:')
				$this->addReport($a);
		}
	}	
}

class aSuspiciousLinkText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $suspicious = array(
		'click here', 'click', 'more', 'here',
	);

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(in_array(strtolower(trim($a->nodeValue)), $this->suspicious))
				$this->addReport($a);
		}
	
	}
}

class aTitleDescribesDestination extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if($a->hasAttribute('title'))
				$this->addReport($a);
		}
	
	}
}

class addressForAuthor extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;


	function check() {
		foreach($this->getAllElements('address') as $address) {
			foreach($address->childNodes as $child) {
				if($child->tagName == 'a')
						return true;
			}
		}
		$this->addReport(null, null, false);
	}

}

class addressForAuthorMustBeValid extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $checkDomain = true;

	
	function check() {
		$this->includeValidate();
		
		foreach($this->getAllElements('address') as $address) {
			if (Validate::email($address->nodeValue, array('check_domain' => $this->checkDomain)))
				return true;
			foreach($address->childNodes as $child) {
				if($child->tagName == 'a' && substr(strtolower($child->getAttribute('href')), 0, 7) == 'mailto:') {
					if(Validate::email(trim(str_replace('mailto:', '', $child->getAttribute('href'))), 
						array('check_domain' => $this->checkDomain)))
							return true;
				
				}
			}
		}
		$this->addReport(null, null, false);
	}


	function includeValidate() {
		require_once('Validate.php');
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletContainsTextEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('applet') as $applet) {
			if(trim($applet->nodeValue) == '' || !$applet->nodeValue)
				$this->addReport($applet);

		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletContainsTextEquivalentInAlt extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	
	function check() {
		foreach($this->getAllElements('applet') as $applet) {
			if(!$applet->hasAttribute('alt') || $applet->getAttribute('alt') == '')
				$this->addReport($applet);

		}
	}

}

class appletProvidesMechanismToReturnToParent extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;


	var $tag = 'applet';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletTextEquivalentsGetUpdated extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'applet';

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletUIMustBeAccessible extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'applet';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletsDoNotFlicker extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'applet';

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class appletsDoneUseColorAlone extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'applet';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaAltIdentifiesDestination extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'area';

}

class areaAltRefersToText extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'area';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaDontOpenNewWindow extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $allowed_targets = array('_self', '_parent', '_top');
	
	function check() {
		foreach($this->getAllElements('area') as $area) {
			if($area->hasAttribute('target') 
				&& !in_array($area->getAttribute('target'), $this->allowed_targets)) {
					$this->addReport($area);
			}
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaHasAltValue extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('area') as $area) {
			if(!$area->hasAttribute('alt'))
				$this->addReport($area);
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class areaLinksToSoundFile extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $extensions = array('wav', 'snd', 'mp3', 'iff', 'svx', 'sam', 'smp', 'vce', 'vox', 'pcm', 'aif');
	
	function check() {
		foreach($this->getAllElements('area') as $area) {
			if($area->hasAttribute('href')) {
				$filename = explode('.', $area->getAttribute('href'));
				$extension = array_pop($filename);
				if(in_array($extension, $this->extensions))
					$this->addReport($area);
			}
		}
	}

}

class basefontIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'basefont';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class blinkIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'blink';

}

class blockquoteNotUsedForIndentation extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('blockquote') as $blockquote) {
			if(!$blockquote->hasAttribute('cite'))
				$this->addReport($blockquote);
		}
	}
}

class blockquoteUseForQuotations extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		$body = $this->getAllelements('body');
		$body = $body[0];
		if(!$body) return false;
		if(strlen($body->nodeValue) > 10)
			$this->addReport(null, null, false);
	
	}

}

class bodyActiveLinkColorContrast extends bodyColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;

	var $foreground = 'alink';
}



class bodyLinkColorContrast extends bodyColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $foreground = 'link';
}

class bodyMustNotHaveBackground extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		$body = $this->getAllElements('body');
		if(!$body)
			return false;
		$body = $body[0];
		if($body->hasAttribute('background'))
			$this->addReport(null, null, false);
	}
}

class bodyVisitedLinkColorContrast extends bodyColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $foreground = 'vlink';
}

class boldIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'bold';
}

class checkboxHasLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'input';
	
	var $type = 'checkbox';
	
	var $no_type = false;
}

class checkboxLabelIsNearby extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'checkbox')
				$this->addReport($input);
			
		}
	}
}

class cssDocumentMakesSenseStyleTurnedOff extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('link') as $link) {
			if($link->parentNode->tagName == 'head') {
				if($link->getAttribute('rel') == 'stylesheet')
					$this->addReport($link);
			}
		}
	}
}

/**
*	Checks that all color and background elements has stufficient contrast.
*
*/
class cssTextHasContrast extends quailColorTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			$style = $this->css->getStyle($element);
			if(($style['background'] || $style['background-color']) && $style['color'] && $element->nodeValue) {
				$background = ($style['background-color'])
							   ? $style['background-color']
							   : $style['background'];
				if(!$background) {
					$background = '#ffffff';
				}
				$luminosity = $this->getLuminosity(
								$style['color'],
								$background
								);
				if($luminosity < 5) {
					$this->addReport($element, 'background: '. $background .' fore: '. $style['color'] . ' lum: '. $luminosity, false);
				}
			}
		}	
		
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class doctypeProvided extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		if(!$this->dom->doctype->publicId)
			$this->addReport(null, null, false);		
	}

}

class documentAbbrIsUsed extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $acronym_tag = 'abbr';
	
	function check() {
		foreach($this->getAllElements($this->acronym_tag) as $acronym) {
			$predefined[strtoupper(trim($acronym->nodeValue))] = $acronym->getAttribute('title');
		}
		$already_reported = array();
		foreach($this->getAllElements(null, 'text') as $text) {

			$words = explode(' ', $text->nodeValue);
			if(count($words) > 1 && strtoupper($text->nodeValue) != $text->nodeValue) {
				foreach($words as $word) {
					$word = preg_replace("/[^a-zA-Zs]/", "", $word);
					if(strtoupper($word) == $word && strlen($word) > 1 && !$predefined[strtoupper($word)])

						if(!$already_reported[strtoupper($word)]) {
							$this->addReport($text, 'Word "'. $word .'" requires an <code>'. $this->acronym_tag .'</code> tag.');
						}
						$already_reported[strtoupper($word)] = true;
				}
			}
		}
		
	}

}

class documentAcronymsHaveElement extends documentAbbrIsUsed {

	var $default_severity = QUAIL_TEST_MODERATE;


	var $acronym_tag = 'acronym';
}

class documentAllColorsAreSet extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
		
	var $color_attributes = array('text', 'bgcolor', 'link', 'alink', 'vlink');
	
	function check() {
		$body = $this->getAllElements('body');
		$body = $body[0];
		if($body) {
			$colors = 0;
			foreach($this->color_attributes as $attribute) {
				if($body->hasAttribute($attribute))
					$colors++;
			}
			if($colors > 0 && $colors < 5)
				$this->addReport(null, null, false);
		}
	}
}


class documentAutoRedirectNotUsed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->hasAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}

class documentColorWaiActiveLinkAlgorithim extends bodyWaiErtColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $foreground = 'alink';
}

class documentColorWaiAlgorithim extends bodyWaiErtColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
		
}

class documentColorWaiLinkAlgorithim extends bodyWaiErtColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $foreground = 'link';
}

class documentColorWaiVisitedLinkAlgorithim extends bodyWaiErtColorContrast {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $foreground = 'vlink';
}

class documentContentReadableWithoutStylesheets extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if($text->hasAttribute('style')) {
				$this->addReport(null, null, false);
				return false;
			}
		}
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentHasTitleElement extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		if(!$element->item(0))
			$this->addReport(null, null, false);
	
	}
}

class documentIDsMustBeUnique extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
		
	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			if($element->hasAttribute('id'))
				$ids[$element->getAttribute('id')][] = $element;
		}	
		foreach($ids as $id) {
			if(count($id) > 1)
				$this->addReport($id[1]);
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentLangIsISO639Standard extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		$languages = file(dirname(__FILE__).'/resources/iso639.txt');
		
		$element = $this->dom->getElementsByTagName('html');
		$html = $element->item(0);
		if(!$html)
			return null;
		if($html->hasAttribute('lang'))
			if(in_array(strtolower($html->getAttribute('lang')), $languages))
				$this->addReport(null, null, false);
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentLangNotIdentified extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		$element = $this->dom->getElementsByTagName('html');
		$html = $element->item(0);
		if(!$html) return null;
		if(!$html->hasAttribute('lang') || trim($html->getAttribute('lang')) == '')
			$this->addReport(null, null, false);
	
	}
}


class documentMetaNotUsedWithTimeout extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('meta') as $meta) {
			if($meta->getAttribute('http-equiv') == 'refresh' && !$meta->getAttribute('content'))
				$this->addReport($meta);
		}
	
	}
}

class documentReadingDirection extends quailTest {


	var $default_severity = QUAIL_TEST_MODERATE;

	var $cms = false;
	
	var $right_to_left = array('he', 'ar');
	function check() {
		$xpath = new DOMXPath($this->dom);
		$entries = $xpath->query('//*');
		foreach($entries as $element) {
			if(in_array($element->getAttribute('lang'), $this->right_to_left)) {

				if($element->getAttribute('dir') != 'rtl')
				 	$this->addReport($element);
			}
		}			
	}
}

class documentStrictDocType extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		if(strpos(strtolower($this->dom->doctype->publicId), 'strict') === false
		   && strpos(strtolower($this->dom->doctype->systemId), 'strict') === false) 
			$this->addReport(null, null, false);
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleDescribesDocument extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $cms = false;
	
	function check() {
		$placeholders = file(dirname(__FILE__).'/resources/placeholder.txt');		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
		if($title) {
				$this->addReport($title);
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleIsNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		$placeholders = file(dirname(__FILE__).'/resources/placeholder.txt');		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
		if($title) {
			if(in_array(strtolower($title->nodeValue), $placeholders))
				$this->addReport(null, null, false);
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleIsShort extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	var $cms = false;
	
	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
		if($title) {
			if(strlen($title->nodeValue)> 150)
				$this->addReport(null, null, false);
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class documentTitleNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		
		$element = $this->dom->getElementsByTagName('title');
		$title = $element->item(0);
			if(trim($title->nodeValue) == '')
				$this->addReport(null, null, false);
	
	}
}

class documentValidatesToDocType extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		if(!@$this->dom->validate())
			$this->addReport(null, null, false);
	}
}

class documentVisualListsAreMarkedUp extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $list_cues = array('*', '<br>*', '¥', '&#8226');
	
	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			foreach($this->list_cues as $cue) {
				$first = stripos($text->nodeValue, $cue);
				$second = strripos($text->nodeValue, $cue);
				if($first && $second && $first != $second)
					$this->addReport($text);
			}
		}
	
	}
}

class documentWordsNotInLanguageAreMarked extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		$body = $this->getAllElements('body');
		$body = $body[0];
		$words = explode(' ', $body->nodeValue);

		if(count($words) > 10)
			$this->addReport(null, null, false);
	}
}

class embedHasAssociatedNoEmbed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if($embed->firstChild->tagName != 'noembed' &&
				$embed->nextSibling->tagName != 'noembed')
					$this->addReport($embed);
		
		}
	}
}

class embedMustHaveAltAttribute extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if(!$embed->hasAttribute('alt'))
					$this->addReport($embed);
		
		}
	}
}

class embedMustNotHaveEmptyAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('embed') as $embed) {
			if($embed->hasAttribute('alt') && trim($embed->getAttribute('alt')) == '')
					$this->addReport($embed);
		
		}
	}
}

class embedProvidesMechanismToReturnToParent extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'embed';
}

class emoticonsExcessiveUse extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$emoticons = file(dirname(__FILE__).'/resources/emoticons.txt', FILE_IGNORE_NEW_LINES);
		$count = 0;
		foreach($this->getAllElements(null, 'text') as $element) {
			if(strlen($element->nodeValue < 2)) {
				$words = explode(' ', $element->nodeValue);
				foreach($words as $word) {
					if(in_array($word, $emoticons)) {
						$count++;
						if($count > 4) {
							$this->addReport(null, null, false);	
							return false;	
						}
					}
				}
			
			}
		}
	
	}
}

class emoticonsMissingAbbr extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$emoticons = file(dirname(__FILE__).'/resources/emoticons.txt', FILE_IGNORE_NEW_LINES);
		$count = 0;
		foreach($this->getAllElements('abbr') as $abbr) {
			$abbreviated[$abbr->nodeValue] = $abbr->getAttribute('title');
		}
		foreach($this->getAllElements(null, 'text') as $element) {
			if(strlen($element->nodeValue < 2)) {
				$words = explode(' ', $element->nodeValue);
				foreach($words as $word) {
					if(in_array($word, $emoticons)) {
						if(!$abbreviated[$word])
							$this->addReport($element);
					}
				}
			
			}
		}
	
	}
}

class fileHasLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'input';
	
	var $type = 'file';
	
	var $no_type = false;
}

class fileLabelIsNearby extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'file')
				$this->addReport($input);
			
		}
	}
}

class fontIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $tag = 'font';
}

class formAllowsCheckIfIrreversable extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'form';
}

class formDeleteIsReversable extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	var $watch_words = array('delete', 'remove', 'erase');
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'submit') {
				foreach($this->watch_words as $word) {
					if(strpos(strtolower($input->getAttribute('value')), $word) !== false) 
						$this->addReport($this->getParent($input, 'form', 'body'));
				}				
			}
		}
	}
}

class formErrorMessageHelpsUser extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'form';
}

class formHasGoodErrorMessage extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'form';
}	

class formWithRequiredLabel extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'form';
}

class frameIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'frame';

	var $cms = false;
	
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class frameRelationshipsMustBeDescribed extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	var $cms = false;
		
	
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
		
			if(!$frameset->hasAttribute('longdesc') && $frameset->childNodes->length > 2)
				$this->addReport($frameset);
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class frameSrcIsAccessible extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $cms = false;
		
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if($frame->hasAttribute('src')) {
				$extension = array_pop(explode('.', $frame->getAttribute('src')));
				if(in_array($extension, $this->image_extensions))
					$this->addReport($frame);
			
			}
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class frameTitlesDescribeFunction extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;	

	var $cms = false;
		
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if($frame->hasAttribute('title'))
				$this->addReport($frame);
		}
	}

}

class frameTitlesNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title') || trim($frame->getAttribute('title')) == '')
				$this->addReport($frame);
		}
	}
}

class frameTitlesNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $placeholders = array('title', 'frame', 'frame title', 'the title');
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(in_array(trim($frame->getAttribute('title')), $this->placeholders))
				$this->addReport($frame);
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class framesHaveATitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;	
	
	var $cms = false;
	
	function check() {
		foreach($this->getAllElements('frame') as $frame) {
			if(!$frame->hasAttribute('title'))
				$this->addReport($frame);
		}
	}

}

class framesetIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
	
	var $tag = 'frameset';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class framesetMustHaveNoFramesSection extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $cms = false;
		
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
			if(!$this->elementHasChild($frameset, 'noframes'))
				$this->addReport($frameset);
		}
	}

}

class headerH1 extends quailHeaderTest {
	
	var $tag = 'h1';
	
}

class headerH1Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'h1';
}

class headerH2 extends quailHeaderTest {
	
	var $tag = 'h2';
	
}

class headerH2Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'h2';
}

class headerH3 extends quailHeaderTest {
	
	var $tag = 'h3';
	
}

class headerH3Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'h3';
}

class headerH4 extends quailHeaderTest {
	
	var $tag = 'h4';
	
}

class headerH4Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'h4';
}

class headerH5 extends quailHeaderTest {
	
	var $tag = 'h5';
	
}

class headerH5Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'h5';
}

class headerH6Format extends quailTagTest{

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'h6';
}

class headersUseToMarkSections extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $non_header_tags = array('strong', 'b', 'em', 'i');
	
	function check() {
		$headers = $this->getAllElements(null, 'header');
		$paragraphs = $this->getAllElements('p');
		if(count($headers) == 0 && count($paragraphs) > 1)
			$this->addReport(null, null, false);
		foreach($paragraphs as $p) {
			if(in_array($p->firstChild->tagName, $this->non_header_tags)
			   || in_array($p->firstChild->nextSibling->tagName, $this->non_header_tags)
			   || in_array($p->previousSibling->tagName, $this->non_header_tags))
				$this->addReport($p);
		}
	}
}

class iIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'i';
}

class iframeMustNotHaveLongdesc extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('iframe') as $iframe) {
			if($iframe->hasAttribute('longdesc'))
				$this->addReport($iframe);
		
		}
	}
}

class imageMapServerSide extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('ismap'))
				$this->addReport($img);
		}
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class imgAltEmptyForDecorativeImages extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	}

}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIdentifiesLinkDestination extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue) {
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img' && $child->hasAttribute('alt'))
						$this->addReport($child);
				}
			}
		}
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class imgAltIsDifferent extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(trim($img->getAttribute('src')) == trim($img->getAttribute('alt')))
				$this->addReport($img);
		}
	}

}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIsSameInText extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltIsTooLong extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt') && strlen($img->getAttribute('alt')) > 100) 
				$this->addReport($img);
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=7&lang=eng
*/
class imgAltNotEmptyInAnchor extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(!$a->nodeValue && $a->childNodes) {
				foreach($a->childNodes as $child) {
					if($child->tagName == 'img'
						&& trim($child->getAttribute('alt')) == '')
							$this->addReport($child);
				}
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgAltNotPlaceHolder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $placeholders = array('nbsp', '&nbsp;', 'spacer', 'image', 'img', 'photo');
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt')) {
				if(in_array($img->getAttribute('alt'), $this->placeholders) || ord($img->getAttribute('alt')) == 194) {
					$this->addReport($img);
				}
				elseif(preg_match("/^([0-9]*)(k|kb|mb|k bytes|k byte)?$/", strtolower($img->getAttribute('alt')))) {
					$this->addReport($img);
				}
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgGifNoFlicker extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $gif_control_extension = "/21f904[0-9a-f]{2}([0-9a-f]{4})[0-9a-f]{2}00/";
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			
			if(substr($img->getAttribute('src'), -4, 4) == '.gif') {
				
				$file = @file_get_contents($this->getPath($img->getAttribute('src')));
				if($file) {
					  $file = bin2hex($file);
					
					  // sum all frame delays
					  $total_delay = 0;
					  preg_match_all($this->gif_control_extension, $file, $matches);
					  foreach ($matches[1] as $match) {
					    // convert little-endian hex unsigned ints to decimals
					    $delay = hexdec(substr($match,-2) . substr($match, 0, 2));
					    if ($delay == 0) $delay = 1;
					    $total_delay += $delay;
					  }
					
					  // delays are stored as hundredths of a second, lets convert to seconds
					  
					 
					 if($total_delay > 0)
					 	$this->addReport($img);
				}
			}
		}
	
	}
}

/**
*   TEST 1 IN OAC
*	All img elements have an alt attribute.
*   Steps To Check
*   Procedure
*   1. Check each img element for the presence of an alt attribute.
*   Expected Result
*   1. All img elements have an alt attribute.
*   Failed Result
*   1. Add an alt attribute to each img element.
*	
*/
class imgHasAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	/**
	*	@var int The OAC test Number
	*/
	var $oac_test = 1;

	/**
	*	@var int The test severity
	*/	
	var $severity = QUAIL_TEST_SEVERE;
	
	/**
	*	The check method of this test. We are iterating through all img
	*	elements and tagging any without an ALT attribute.
	*/
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(!$img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=8&lang=eng
*/
class imgHasLongDesc extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('longdesc')) {
				$this->addReport($img);
					
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=5&lang=eng
*/
class imgImportantNoSpacerAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('src') && $img->hasAttribute('alt') && trim($img->getAttribute('alt')) == '') {
				if($img->getAttribute('width') > 25 || $img->getAttribute('height') > 25)
					$this->addReport($img);
				elseif(IMAGECLASS_EXISTS) {
					try {
						$img_file = wiImage::load($img->getAttribute('src'));
						
						
						if($img_file->getWidth() > 25 || $img_file->getHeight() > 25)
							$this->addReport($img);
					}
					catch(Exception $e) {
					
					}
				}
			}

		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgMapAreasHaveDuplicateLink extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $placeholders = array('nbsp', '&nbsp;', 'spacer', 'image', 'img', 'photo', ' ');
	
	function check() {
		foreach($this->getAllElements('a') as $a) {
			$all_links[$a->getAttribute('href')] = $a->getAttribute('href');
		}
		$maps = $this->getElementsByAttribute('map', 'name', true);
		
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('usemap')) {
				$usemap = $img->getAttribute('usemap');
				if(substr($usemap, 0, 1) == '#')
					$key = substr($usemap, -(strlen($usemap) - 1), (strlen($usemap) - 1));
				else
					$key = $usemap;
				foreach($maps[$key]->childNodes as $child) {
					if($child->tagName == 'area') {
						
						if(!$all_links[$child->getAttribute('href')])
							$this->addReport($img);
					}
				}
			
			
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=9
*/
class imgNeedsLongDescWDlink extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('longdesc')) {
				$next = $this->getNextElement($img);
				
				if($next->tagName != 'a') 
					$this->addReport($img);
				else {
					
					if(((strtolower($next->nodeValue) != '[d]' && strtolower($next->nodeValue) != 'd') )
						|| $next->getAttribute('href') != $img->getAttribute('longdesc')) {
							$this->addReport($img);
					}
				}
					
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=4&lang=eng
*/
class imgNonDecorativeHasAlt extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('src') && 
				($img->hasAttribute('alt') && html_entity_decode((trim($img->getAttribute('alt')))) == '')) {
				$this->addReport($img);
				
			}
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgNotReferredToByColorAlone extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('alt'))
				$this->addReport($img);
		}
	
	}
}

class imgServerSideMapNotUsed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('ismap'))
				$this->addReport($img);
		}
	}
}

class imgShouldNotHaveTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('title'))
				$this->addReport($img);
		}
	
	}
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class imgWithMapHasUseMap extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('img') as $img) {
			if($img->hasAttribute('ismap') && !$img->hasAttribute('usemap'))
				$this->addReport($img);
		}
	
	}
}

class imgWithMathShouldHaveMathEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('img') as $img) {
			if(($img->getAttribute('width') > 100 
				|| $img->getAttribute('height') > 100 )
				&& $img->nextSibling->tagName != 'math')
					$this->addReport($img);
		
		}
	}
}

class inputCheckboxHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;
	var $tag = 'input';
	
	var $type = 'checkbox';
}

class inputCheckboxRequiresFieldset extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'checkbox') {
				if(!$this->getParent($input, 'fieldset', 'body'))
					$this->addReport($input);
				
			}
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputDoesNotUseColorAlone extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') != 'hidden')
				$this->addReport($input);
		}
	}

}

class inputElementsDontHaveAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') != 'image' && $input->hasAttribute('alt'))
				$this->addReport($input);
		}
	}
}

class inputFileHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;
	var $tag = 'input';
	
	var $type = 'file';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIdentifiesPurpose extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image')
				$this->addReport($input);
		}
	}

}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIsNotFileName extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' 
				&& strtolower($input->getAttribute('alt')) == strtolower($input->getAttribute('src')))
					$this->addReport($input);
		}
	}

}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class inputImageAltIsNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $placeholders = array('nbsp', '&nbsp;', 'input', 'spacer', 'image', 'img', 'photo', ' ');
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image') {
				if(in_array($input->getAttribute('alt'), $this->placeholders) || ord($input->getAttribute('alt')) == 194) {
					$this->addReport($input);
				}
				elseif(preg_match("/^([0-9]*)(k|kb|mb|k bytes|k byte)?$/", strtolower($input->getAttribute('alt')))) {
					$this->addReport($input);
				}
			}
		}
	
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageAltIsShort extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' && strlen($input->getAttribute('alt')) > 100)
				$this->addReport($input);
		}
	}

}

class inputImageAltNotRedundant extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $problem_words = array('submit', 'button');

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image') {
				foreach($this->problem_words as $word) {
					if(strpos($input->getAttribute('alt'), $word) !== false)
							$this->addReport($input);
				}
			}
		}
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputImageHasAlt extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image' 
					&& (trim($input->getAttribute('alt')) == '' || !$input->hasAttribute('alt')))
				$this->addReport($input);
		}
	}

}

class inputImageNotDecorative extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'image')
				$this->addReport($input);
		}
	}
}

class inputPasswordHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;
	var $tag = 'input';
	
	var $type = 'password';
}

class inputRadioHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;
	var $tag = 'input';
	
	var $type = 'radio';
}

class inputSubmitHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;
	var $tag = 'input';
	
	var $type = 'submit';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class inputTextHasLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $tag = 'input';
	
	var $type = 'text';
	
	var $no_type = false;
}

class inputTextHasTabIndex extends inputTabIndex {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'input';
	
	var $type = 'text';
}
/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=1&lang=eng
*/
class inputTextHasValue extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'text' && !$input->hasAttribute('value'))
				$this->addReport($input);	
			
		}
	
	}
}

class inputTextValueNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('input') as $input) {
			if(!$input->hasAttribute('value') || trim($input->getAttribute('value')) == '')
					$this->addReport($input);
			
		}
	}
}

class labelDoesNotContainInput extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($this->elementHasChild($label, 'input') || $this->elementHasChild($label, 'textarea'))
				$this->addReport($label);
		}
	}
}

class labelMustBeUnique extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	function check() {
		foreach($this->getAllElements('label') as $label) {
			if($label->hasAttribute('for'))
				$labels[$label->getAttribute('for')][] = $label;
		}
		foreach($labels as $label) {
			if(count($label) > 1)
				$this->addReport($label[1]);
		}
	}
}

class labelMustNotBeEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('label') as $label) {
			if(trim($label->nodeValue) == '') {
				$fail = true;
				foreach($label->childNodes as $child) {
					if($child->tagName == 'img' && trim($child->getAttribute('alt')) != '')
						$fail = false;
				}
				if($fail)
					$this->addReport($label);
				
			}
		}
	}
}

class legendDescribesListOfChoices extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'legend';
}

class legendTextNotEmpty extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('legend') as $legend) {
			if(!$legend->nodeValue || trim($legend->nodeValue) == '')
				$this->addReport($legend);
		}
	}
}

class legendTextNotPlaceholder extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $placeholders = array('&nbsp;', ' ', 'legend');
	
	function check() {
		foreach($this->getAllElements('legend') as $legend) {
			if(in_array(trim($legend->nodeValue), $this->placeholders))
				$this->addReport($legend);
		}
	}

}

class liDontUseImageForBullet extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATe;

	function check() {
		foreach($this->getAllElements('li') as $li) {
			if(trim($li->nodeValue) != '' && $li->firstChild->tagName == 'img')
				$this->addReport($li);
		}
	
	}
}

class linkUsedForAlternateContent extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		$head = $this->getAllElements('head');
		$head = $head[0];
		foreach($head->childNodes as $child) {
			if($child->tagName == 'link' && $child->getAttribute('rel') == 'alternate')
				return true;
		}
		$this->addReport(null, null, false);
	}
}



class linkUsedToDescribeNavigation extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		$head = $this->getAllElements('head');
		$head = $head[0];
		if($head->childNodes) {
			foreach($head->childNodes as $child) {
				if($child->tagName == 'link' && $child->getAttribute('rel') != 'stylesheet')
					return true;
			}
			$this->addReport(null, null, false);
		}
	}
}

class listNotUsedForFormatting extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements(array('ul', 'ol')) as $list) {
			$li_count = 0;
			foreach($list->childNodes as $child) {
				if($child->tagName == 'li')
					$li_count++;
			}
			if($li_count < 2)
				$this->addReport($list);
		}
	
	}
}

class marqueeIsNotUsed extends quailTagTest {

	var $default_severity = QUAIL_TEST_SEVERE;
	
	var $tag = 'marquee';

}

class menuNotUsedToFormatText extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('menu') as $menu) {
			$list_items = 0;
			foreach($menu->childNodes as $child) {
				if($child->tagName == 'li')
					$list_items++;
			}
			if($list_items == 1)
				$this->addReport($menu);
		}
	
	}
}

class noembedHasEquivalentContent extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'noembed';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class noframesSectionMustHaveTextEquivalent extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	
	function check() {
		foreach($this->getAllElements('frameset') as $frameset) {
			if(!$this->elementHasChild($frameset, 'noframes'))
				$this->addReport($frameset);
		}
		foreach($this->getAllElements('noframes') as $noframes) {
			$this->addReport($noframes);
		}
	}

}

class objectContentUsableWhenDisabled extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class objectDoesNotFlicker extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';

}

class objectDoesNotUseColorAlone extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}

class objectInterfaceIsAccessible extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}


class objectLinkToMultimediaHasTextTranscript extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->getAttribute('type') == 'video')
				$this->addReport($object);
			
		}
	}

}

class objectMustContainText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->nodeValue || trim($object->nodeValue) == '')
				$this->addReport($object);
		
		}
	}
}

class objectMustHaveEmbed extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$this->elementHasChild($object, 'embed'))
				$this->addReport($object);
		}
	}
}

class objectMustHaveTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if(!$object->hasAttribute('title'))
				$this->addReport($object);
			
		}
	}

}



class objectMustHaveValidTitle extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

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

class objectProvidesMechanismToReturnToParent extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;
	var $tag = 'object';
}

class objectShouldHaveLongDescription extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}

class objectTextUpdatesWhenObjectChanges extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}

class objectUIMustBeAccessible extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'object';
}

class objectWithClassIDHasNoText extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('object') as $object) {
			if($object->nodeValue && $object->hasAttribute('classid'))
				$this->addReport($object);
		
		}
	}
}

class pNotUsedAsHeader extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $head_tags = array('strong', 'span', 'em', 'font', 'i', 'b', 'u');
	
	function check() {
		foreach($this->getAllElements('p') as $p) {
			if(($p->nodeValue == $p->firstChild->nodeValue)
				&& in_array($p->firstChild->tagName, $this->head_tags))
				$this->addReport($p);
		}
	}
}

class passwordHasLabel extends inputTextHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'input';
	
	var $type = 'password';
	
	var $no_type = true;
}

class passwordLabelIsNearby extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'password')
				$this->addReport($input);
			
		}
	}
}

class preShouldNotBeUsedForTabularLayout extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('pre') as $pre) {
			$rows = preg_split('/[\n\r]+/', $pre->nodeValue);
			if(count($rows) > 1)
				$this->addReport($pre);
		}
	
	}
}

class radioHasLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'input';
	
	var $type = 'radio';
	
	var $no_type = false;
}

class radioLabelIsNearby extends quailTest {

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'radio')
				$this->addReport($input);
			
		}
	}
}


class radioMarkedWithFieldgroupAndLegend extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('input') as $input) {
			if($input->getAttribute('type') == 'radio') {
				$radios[$input->getAttribute('name')][] = $input;
			}
		}
		if(is_array($radios)) {
			foreach($radios as $radio) {
				if(count($radio > 1)) {
					if(!$this->getParent($radio[0], 'fieldset', 'body'))
						$this->addReport($radio[0]);
				}
			}
		}
	}
}

/**
*	@todo This should really only fire once and shouldn't extend quailTagTest
*/
class scriptContentAccessibleWithScriptsTurnedOff extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'script';
}

class scriptInBodyMustHaveNoscript extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('script') as $script) {
			if($script->nextSibling->tagName != 'noscript' 
				&& $script->parentNode->tagName != 'head')
					$this->addReport($script);
		
		}
	}

}

class scriptOnclickRequiresOnKeypress extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $click_value = 'onclick';
	
	var $key_value = 'onkeypress';
	
	function check() {
		foreach($this->getAllElements(array_keys(htmlElements::$html_elements)) as $element) {
			if(($element->hasAttribute($this->click_value)) && !$element->hasAttribute($this->key_value))
				$this->addReport($element);
		}
	}

}

class scriptOndblclickRequiresOnKeypress extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'ondblclick';
}

class scriptOnmousedownRequiresOnKeypress extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'onmousedown';
	
	var $key_value = 'onkeydown';
}

class scriptOnmousemove extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $click_value = 'onmousemove';
	
	var $key_value = 'onkeypress';
	
	function check() {
		foreach($this->getAllElements(array_keys(htmlElements::$html_elements)) as $element) {
			if(($element->hasAttribute($this->click_value)))
				$this->addReport($element);
		}
	}

}

class scriptOnmouseoutHasOnmouseblur extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'onmouseout';
	
	var $key_value = 'onblur';
}


class scriptOnmouseoverHasOnfocus extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'onmouseover';
	
	var $key_value = 'onfocus';
}


class scriptOnmouseupHasOnkeyup extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'onmouseup';
	
	var $key_value = 'onkeyup';
}

class scriptUIMustBeAccessible extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'script';
}

class scriptsDoNotFlicker extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'script';
}

class scriptsDoNotUseColorAlone extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'script';
}

class selectDoesNotChangeContext extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('select') as $select) {
			if($select->hasAttribute('onchange'))
				$this->addReport($select);
		
		}
	}
}

class selectHasAssociatedLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'select';
	
	var $no_type = true;
}

class selectWithOptionsHasOptgroup extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('select') as $select) {
			$options = 0;
			foreach($select->childNodes as $child) {
				if($child->tagName == 'option')
					$options++;
			}
			if($options >= 4)
				$this->addReport($select);
		}
	}
}

class siteMap extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('a') as $a) {
			if(strtolower(trim($a->nodeValue)) == 'site map')
				return true;
		}
		$this->addReport(null, null, false);
	}
}

/**
*	http://checker.atrc.utoronto.ca/servlet/ShowCheck?check=2&lang=eng
*/
class skipToContentLinkProvided extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
	var $search_words = array('navigation', 'skip', 'content');
	
	function check() {
		$first_link = $this->getAllElements('a');
		if(!$first_link) {
			$this->addReport(null, null, false);
		}
		$a = $first_link[0];
		
		if(substr($a->getAttribute('href'), 0, 1) == '#') {
			
			$link_text = explode(' ', strtolower($a->nodeValue));
			if(!in_array($this->search_words, $link_text)) {
				$report = true;
				foreach($a->childNodes as $child) {
					if(method_exists($child, 'hasAttribute')) {
						if($child->hasAttribute('alt')) {
							$alt = explode(' ', strtolower($child->getAttribute('alt') . $child->nodeValue));
							foreach($this->search_words as $word) {
								if(in_array($word, $alt)) {
									$report = false;
								}
							}
						}
					}
				}
				if($report) {
					$this->addReport(null, null, false);
				}
			}
		
		}
		else
			$this->addReport(null, null, false);

	}

} 

class tabIndexFollowsLogicalOrder extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;
	
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

class tableCaptionIdentifiesTable extends quailTagTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	var $tag = 'caption';
}

class tableComplexHasSummary extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$table->hasAttribute('summary') && $table->firstChild->tagName != 'caption') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}

class tableDataShouldHaveTh extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->isData($table))
				$this->addReport($table);
		
		}
	
	}

}

class tableHeaderLabelMustBeTerse extends quailTableTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			foreach($table->childNodes as $child) {
				if($child->tagName == 'tr') {
					foreach($child->childNodes as $td) {
						if($td->tagName == 'th') {
							if(strlen($td->getAttribute('abbr')) > 20)
								$this->addReport($td);
						
						}
					}
				}
			}
			
		}
	
	}
}

class tableIsGrouped extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->elementHasChild($table, 'thead') 
					|| !$this->elementHasChild($table, 'tbody') 
					|| !$this->elementHasChild($table, 'tfoot')) {
				$rows = 0;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr')
						$rows ++;
				}
				if($rows > 4)
					$this->addReport($table);
			}		
		}
	
	}
}

class tableLayoutDataShouldNotHaveTh extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->isData($table))
				$this->addReport($table);
		
		}
	
	}

}

class tableLayoutHasNoCaption extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->elementHasChild($table, 'caption')) {
				$first_row = true;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr' && $first_row) {
						if(!$this->elementHasChild($child, 'th'))
							$this->addReport($table);
						$first_row = false;
					}
				}
			}
		}
	
	}
}

class tableLayoutHasNoSummary extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && strlen(trim($table->getAttribute('summary'))) > 1) {
				$first_row = true;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr' && $first_row) {
						if(!$this->elementHasChild($child, 'th'))
							$this->addReport($table);
						$first_row = false;
					}
				}
			}
		}
	
	}
}

class tableLayoutMakesSenseLinearized extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if(!$this->isData($table))
				$this->addReport($table);
		
		}
	
	}

}

class tableSummaryDescribesTable extends quailTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary'))
				$this->addReport($table);
		}
	}
}


class tableSummaryDoesNotDuplicateCaption extends quailTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->elementHasChild($table, 'caption') && $table->hasAttribute('summary')) {
				foreach($table->childNodes as $child) {
					if($child->tagName == 'caption')
						$caption = $child;
				}
				if(strtolower(trim($caption->nodeValue)) == 
						strtolower(trim($table->getAttribute('summary'))) ) 
				 $this->addReport($table);
				
			}
		}
	}
}

class tableSummaryIsEmpty extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && trim($table->getAttribute('summary')) == '') {
				$this->addReport($table);
			
			
			}
		}
	
	}
}

class tableSummaryIsSufficient extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->hasAttribute('summary') && strlen(trim($table->getAttribute('summary'))) < 11) {
				$this->addReport($table);
			
			
			}
		}
	
	}
}

class tableUseColGroup extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->isData($table)) {
				if(!$this->elementHasChild($table, 'colgroup') && !$this->elementHasChild($table, 'col'))
					$this->addReport($table);
			}
		}
	
	}
}

class tableUsesAbbreviationForHeader extends quailTableTest {

	var $default_severity = QUAIL_TEST_SUGGESTION;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			foreach($table->childNodes as $child) {
				if($child->tagName == 'tr') {
					foreach($child->childNodes as $td) {
						if($td->tagName == 'th') {
							if(strlen($td->nodeValue) > 20 && !$td->hasAttribute('abbr'))
								$this->addReport($table);
						
						}
					}
				}
			}
			
		}
	
	}
}

class tableUsesCaption extends quailTableTest {

	var $default_severity = QUAIL_TEST_SEVERE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($table->firstChild->tagName != 'caption')
				$this->addReport($table);
			
		}
	
	}
}

class tableWithBothHeadersUseScope extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			$fail = false;
			foreach($table->childNodes as $child) {
				if($child->tagName == 'tr') {
					if($child->firstChild->tagName == 'td') {
						if(!$child->firstChild->hasAttribute('scope'))
							$fail = true;
					}
					else {
						foreach($child->childNodes as $td) {
							if($td->tagName == 'th' && !$td->hasAttribute('scope'))
								$fail = true;
						}
					}
				}
			}
			if($fail)
				$this->addReport($table);
		}
	}
}

class tableWithMoreHeadersUseID extends quailTableTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements('table') as $table) {
			if($this->isData($table)) {
				
				$row = 0;
				$multi_headers = false;
				foreach($table->childNodes as $child) {
					if($child->tagName == 'tr') {
						$row ++;
						foreach($child->childNodes as $cell) {
							if($cell->tagName == 'th') {
								$th[] = $cell;
								if($row > 1) 
									$multi_headers = true;	
							}
								
						}
					}
				}
				if($multi_headers) {
					$fail = false;
					foreach($th as $cell) {
						if(!$cell->hasAttribute('id'))
							$fail = true;
					}
					if($fail)
						$this->addReport($table);
				} 
				
			}
		}
	}
}

class tabularDataIsInTable extends quailTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	function check() {
		foreach($this->getAllElements(null, 'text') as $text) {
			if(strpos($text->nodeValue, "\t") !== false || $text->tagName == 'pre')
				$this->addReport($text);
		}
	}
}

class textareaHasAssociatedLabel extends inputHasLabel {

	var $default_severity = QUAIL_TEST_SEVERE;

	var $tag = 'textarea';
	
	var $no_type = true;
}

class textareaLabelPositionedClose extends quailTagTest {

	var $default_severity = QUAIL_TEST_MODERATE;

	var $tag = 'textarea';
}