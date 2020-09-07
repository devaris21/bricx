<?php 
namespace Home;

$title = "BRICX | Toutes les commandes en cours";

GROUPECOMMANDE::etat();
$encours = GROUPECOMMANDE::encours();
$groupes = $agence->fourni("groupecommande", ["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>