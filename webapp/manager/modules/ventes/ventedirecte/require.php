<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "BRICX | Toutes les ventes";


$encours = $agence->fourni("vente", ["agence_id ="=>$agence->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$ventes = $agence->fourni("vente", ["agence_id ="=>$agence->id, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>