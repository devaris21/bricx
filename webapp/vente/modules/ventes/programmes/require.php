<?php 
namespace Home;

$title = "BRICX | Toutes les livraisons";

$encours = LIVRAISON::findBy(["agence_id ="=>$agence->id, "etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);

$total = count($encours);

?>