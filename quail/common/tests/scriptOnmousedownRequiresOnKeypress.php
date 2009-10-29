<?php

require_once('scriptOnclickRequiresOnKeypress.php');
class scriptOnmousedownRequiresOnKeypress extends scriptOnclickRequiresOnKeypress {

	var $click_value = 'onmousedown';
	
	var $key_value = 'onkeydown';
}