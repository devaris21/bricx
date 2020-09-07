<?php 
namespace Home;

$title = "BRICX | Rangements de la production";

$datas = MISEENBOUTIQUE::findBy([], [], ["created"=>"DESC"]);


?>