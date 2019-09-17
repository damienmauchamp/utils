<?php

function in_array_count($needle, $haystack) {
	return count(array_keys($haystack, $needle));
}

function in_array_count_check($needle, $haystack, $times) {
	$values = array_count_values($haystack);
	return isset($values[$needle] ? $values[$needle] : 0);
}

function recuperer_valeur_par_colonne($array, $valeur, $colonne, $retourner_index = false) {
	$index = array_search($valeur, array_column($array, $colonne));
	// vérification que $index !== false
	return (!(is_bool($index) && !$index) && isset($array[$index])) ? ($retourner_index ? array('index' => $index, 'item' => $array[$index]) : $array[$index]) : false;
}

function multi_recuperer_valeur_par_colonne($array, $valeur, $colonne, $retourner_index = false) {
	foreach ($array as $item) {
		$return = recuperer_valeur_par_colonne($item, $valeur, $colonne, $retourner_index);
		if ($return) {
			return $return;
		}
	}
	return false;
}

function starts_with($haystack, $needle)
{
    return (substr($haystack, 0, strlen($needle)) === $needle);
}

function ends_with($haystack, $needle)
{
    $length = strlen($needle);
    return $length === 0 || (substr($haystack, -$length) === $needle);
}

/**
 * Vérifie l'existence d'une clé dans un tableau et renvoie sa valeur en conséquence
 * @param mixed $cle
 * @param array $tableau
 * @param mixed $defaut valeur à retourner si la clé n'existe pas
 * @return mixed
 */
function recuperer_valeur_tableau($cle, $tableau, $defaut = false) {
	if(gettype($tableau) !== 'array' || !$tableau || !array_key_exists($cle, $tableau)) {
		return $defaut;
	}
	return $tableau[$cle];
}

function remove_accents($str, $charset='utf-8') {
    $str = htmlentities( $str, ENT_NOQUOTES, $charset );
    $str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
    $str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
    $str = preg_replace( '#&[^;]+;#', '', $str );
    return $str;
}

function remove_special_chars($str, $replace = '') {
	return trim(preg_replace('/[^A-Za-zÀ-ÖØ-öø-ÿ]+/', $replace, $str), $replace);
}


function strto($str, $params = [], $charset = "utf-8") {
	if (!$params || !is_array($params)) {
		return $str;		
	}
	
	if (in_array('remove_accents', $params)) {
		$str = remove_accents($str, $charset);
	}
	
	if (in_array('lowercase', $params)) {
		$str = mb_strtolower($str);
	}
	
	if (in_array('uppercase', $params)) {
		$str = mb_strtoupper($str);
	}
	
	return $str;
}