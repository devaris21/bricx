<?php 
namespace Home;

$title = "BRICX | Tous les fournisseurs";

$fournisseurs = FOURNISSEUR::findBy(["visibility ="=>1]);


?>