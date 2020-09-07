<?php 
namespace Home;

unset_session("ressources");

$title = "BRICX | Toutes les approvisionnements de ressources";


$encours = $agence->fourni("approvisionnement", ["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$datas = $agence->fourni("approvisionnement", ["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>