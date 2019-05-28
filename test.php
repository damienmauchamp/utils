<?php

define('REGEX_PHP_FUNCTION', '/function\s+(?<names>[^()]+)/m');
define('REGEX_JS_FUNCTION', '/function\s+(?<names>[^()]+)/m');
define('FILE_PHP_FUNCTIONS', 'php/functions.php');
define('FILE_JS_FUNCTIONS', 'js/functions.js');

include_once FILE_PHP_FUNCTIONS;
//include_once FILE_JS_FUNCTIONS;

class FunctionsManager {

	public function __construct() {
	}

	// js

	public function getJSFunctions() {
		return $this->getFunctions('js');
	}

	public function getJSFunction($name) {
		return $this->getFunction('js', $name);
	}

	// php

	public function getPHPFunctions() {
		return $this->getFunctions('php');
	}

	public function getPHPFunction($name) {
		return $this->getFunction('php', $name);
	}

	// common

	private function getTypeInfo($type) {
		switch($type) {
			case 'js':
				$file = FILE_JS_FUNCTIONS;
				$regex = REGEX_JS_FUNCTION;
				break;
			case 'php':
				$file = FILE_PHP_FUNCTIONS;
				$regex = REGEX_PHP_FUNCTION;
				break;
			default:
				return false;
		}
		return (object) array(
			'file' => $file,
			'regex' => $regex
		);
	}

	private function getFunctions($type) {
		$lang = $this->getTypeInfo($type);
		$content = file_get_contents($lang->file);
		preg_match_all($lang->regex, $content, $matches);
		$functions = $matches['names'];
		sort($functions);
		return $functions;
	}

	private function getFunction($type, $name) {
		$lang = $this->getTypeInfo($type);
		$body = '';

		if ($type === 'php') {
			$f = new ReflectionFunction($name);
			$filename = $f->getFileName();
			$start_line = $f->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
			$end_line = $f->getEndLine();
			$length = $end_line - $start_line;
			$source = file($filename);
			$body = implode("", array_slice($source, $start_line, $length));
		} else if ($type === 'js') {
			$content = file_get_contents($lang->file);
			preg_match('/function\s+' . $name . '\s*\(/', $content, $matches, PREG_OFFSET_CAPTURE);
			if (!$matches) {
				return $body;
			}
			$start = $matches[0][1];
			$bracketsCount = 0;
			$return = false;
			for ($i = $start ; $i < strlen($content) ; $i++) {

				$char = $content[$i];

				if ($char === '{') {
					$return = true;
					$bracketsCount++;
				} else if ($char === '}') {
					$bracketsCount--;
				}
				$body .= $char;

				if ($bracketsCount === 0 && $return) {
					break;
				}
			}
		}
		return $body;

	}


}
//

$fm = new FunctionsManager();

var_dump("JS");
var_dump($fm->getJSFunctions());
var_dump($fm->getJSFunction('OKOKOKOK'));

var_dump("PHP");
var_dump($fm->getPHPFunctions());
var_dump($fm->getPHPFunction('azer_ty9'));


exit;

function __getFunctions() {
	$content = file_get_contents(FILE_PHP_FUNCTIONS);
	preg_match_all(REGEX_PHP_FUNCTION, $content, $matches);
	return $matches['names'];
}

function __getFunctionContent($name) {
	$func = new ReflectionFunction($name);
	$filename = $func->getFileName();
	$start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
	$end_line = $func->getEndLine();
	$length = $end_line - $start_line;
	$source = file($filename);
	$body = implode("", array_slice($source, $start_line, $length));
	return $body;
}

$functions = __getFunctions();

foreach ($functions as $function) {
	echo "
		<h1>" . $function . "</h1>
		<pre>" . __getFunctionContent($function) . "</pre>";
}