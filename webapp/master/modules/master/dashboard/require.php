<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$params = PARAMS::findLastId();

GROUPECOMMANDE::etat();


$groupes__ = GROUPECOMMANDE::encours();

$approvisionnements__ = APPROVISIONNEMENT::encours();

$title = "BRICX | Tableau de bord";

?>