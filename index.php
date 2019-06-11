<?php

define('REGEX_PHP_FUNCTION', '/function\s+(?<names>[^()]+)/m');
define('REGEX_JS_FUNCTION', '/function\s+(?<names>[^()]+)/m');
//define('REGEX_JS_FUNCTION_WITH_CUSTOM', '/((\w+|\$)\.\w+\.(?<custom_names>[^()]+)\s+=\s+)?function\s*(?<names>[^()]+)?/m');
define('REGEX_JS_FUNCTION_WITH_CUSTOM', '/(((\w+|\$)\.\w+\.(?<custom_names>[^()]+)\s+=\s+)|^)function\s*(?<names>[^()]+)?/m');
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
				//$regex = REGEX_JS_FUNCTION;
			$regex = REGEX_JS_FUNCTION_WITH_CUSTOM;
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
		$functions = isset($matches['custom_names']) ? array_merge($matches['names'], $matches['custom_names']) : $matches['names'];
		sort($functions);
		return array_filter($functions, function ($value) {
			return $value;
		});
	}

	private function getFunction($type, $name) {
		$lang = $this->getTypeInfo($type);
		$body = '';

		if ($type === 'php') {
			$f = new ReflectionFunction($name);
			$filename = $f->getFileName();
			$start_line = $f->getStartLine() - 1; // -1 to get the function() block
			$end_line = $f->getEndLine();
			$length = $end_line - $start_line;
			$source = file($filename);
			$body = implode("", array_slice($source, $start_line, $length));
		} else if ($type === 'js') {
			$content = file_get_contents($lang->file);
			preg_match('/function\s+' . $name . '\s*\(/', $content, $matches, PREG_OFFSET_CAPTURE);
			if (!$matches) {
				preg_match('/((\w+|\$)\.\w+\.' . $name . '\s+=\s+)function\s*\(/', $content, $matches, PREG_OFFSET_CAPTURE);
				if (!$matches) {
					return $body;
				}
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

$functions = (object) array(
	'js' => $fm->getJSFunctions(),
	'php' => $fm->getPHPFunctions()
);

function displayFunctions($functions) {
	$options = '';
	foreach ($functions as $function) {
		$options .= '<option value="' . $function . '">' . $function . '</option>';
	}
	return $options;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Hey</title>
	<link href="lib/prism/prism.css" rel="stylesheet" />
</head>
<body>

	<h1>JS</h1>
	<select>
		<?= displayFunctions($functions->js) ?>
	</select>
	<pre><code class="language-javascript"><?= $fm->getJSFunction('startsWith') ?></code></pre>
	<hr/>

	<h1>PHP</h1>
	<select>
		<?= displayFunctions($functions->php) ?>
	</select>
	<pre><code class="language-php"><?= $fm->getPHPFunction($functions->php[3]) ?></code></pre>
	<hr/>

	<script src="lib/prism/prism.js"></script>
</body>
</html>