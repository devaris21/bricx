<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$produits = $ressources = [];

foreach (PRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->produit = $item->production($date1, $date2, $agence->id) + $item->production($date1, $date2, $agence->id);
		$produits[] = $item;
}

foreach (RESSOURCE::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->consomme = $item->consommee($date1, $date2, $agence->id);
		$ressources[] = $item;
}



$stats = PRODUCTION::stats($date1, $date2, $agence->id);

$title = "BRICX | Rapport de production ";

$lots = [];
?>