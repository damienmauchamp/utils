<?php

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