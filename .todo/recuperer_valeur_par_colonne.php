<?php
// test
$index = 0;
echo (!(is_bool($index) && !$index) && true) ? "IS NOT FALSE" : "IS FALSE";

function recuperer_valeur_par_colonne($array, $valeur, $colonne) {
    $index = array_search($valeur, array_column($array, $colonne));
    // vérification que $index !== false
    return (!(is_bool($index) && !$index) && isset($array[$index])) ? $array[$index] : false;
}