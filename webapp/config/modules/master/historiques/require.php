<?php 
namespace Home;


$title = "BRICX | Historiques & Traçabilité ";

$datas = HISTORY::findBy(["DATE(created) >="=>dateAjoute(-1)], [], ["created"=>"DESC"]);

?>