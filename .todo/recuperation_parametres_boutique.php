<?
/**
 * @param mixed $parametres (string ou array)
 * @param type $id_boutique
 * @return type
 */
function recuperation_parametres_boutique($parametres, $id_boutique = 1) {
    $fin_condition = "";
    $retour = array();

    if (is_array($parametres)) { // tableau de paramètres
        $fin_condition = " AND code_parametre_boutique_web IN ('" . implode(',', $parametres) . "')";
    } else if (!in_array($parametres, ['*', ''])) { // un paramètre en particulier
        $fin_condition = " AND code_parametre_boutique_web = '" . $parametres . "'";
    }

    while ($ligne_param = mysqli_fetch_assoc(mysqli_query_exec("SELECT code_parametre_boutique_web, valeur_parametre_boutique_web FROM boutique_web_parametre WHERE id_boutique_web_parametre_boutique_web=$id_boutique $fin_condition"))) {
        $retour[$ligne_param['code_parametre_boutique_web']] = $ligne_param['valeur_parametre_boutique_web'];
        //$$ligne_param['code_parametre_boutique_web'] = $ligne_param['valeur_parametre_boutique_web'];
    }
    return $retour;
}