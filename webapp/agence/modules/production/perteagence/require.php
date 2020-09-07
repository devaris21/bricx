<?php 
namespace Home;

$title = "BRICX | Toutes les pertes agences";

unset_session("produits");


$encours = $agence->fourni("perteagence", ["agence_id ="=>$agence->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);


$datas = $agence->fourni("perteagence", ["agence_id ="=>$agence->id, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>