<?php 
namespace Home;

$title = "BRICX | Toutes les productions";

unset_session("produits");

$productionjour = PRODUCTION::today();
$productionjour->actualise();
session("lastUrl", $this->url);

$mises__ = $agence->fourni("production", ["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);;
$encours2 = $agence->fourni("production", ["etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);
$encours = array_merge($mises__, $encours2);


$datas1 = $agence->fourni("production", ["etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas2 = $agence->fourni("production", ["etat_id ="=>ETAT::ANNULEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas = array_merge($datas1, $datas2);

?>