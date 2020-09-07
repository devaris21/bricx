<?php 
namespace Home;

unset_session("produits");

$title = "BRIXS | Toutes les achats de stock";

$encours = ACHATSTOCK::findBy(["etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);

$datas = ACHATSTOCK::findBy(["etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>