<?php

$method = 'post';
$_VAR = $method === 'get' ? $_GET : $_POST;

$action = isset($_VAR['action']) ? $_VAR['action'] : '';
$str = isset($_VAR['content']) ? $_VAR['content'] : '';

switch ($action) {
	case 'consolelog':
		echo consolelog($str);
		break;
	case 'consolelog_functions':
		echo consolelog_functions($str);
		break;
	default:
		echo '';
		break;
}

function consolelog($str) {
	$res = '';
	foreach (explode(',', $str) as $item) {
		$res.= "'" . trim($item) .":' + $item, ";
	}
	return "console.log('XXXXX', " . substr($res, 0, -2) . ");";
}

function consolelog_functions($str) {

	return $str;
}