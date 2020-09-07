<?php 
namespace Home;

$title = "BRICX | Tous les clients !";
$clients = CLIENT::findBy(["visibility ="=>1],[],["name"=>"ASC"]);

?>