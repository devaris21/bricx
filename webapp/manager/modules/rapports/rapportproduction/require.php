<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = $agences = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, null, $item->id);
		$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, null, null, $item->id);
		$typeproduits[] = $item;
}


foreach (AGENCE::getAll() as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, $item->id);
		$agences[] = $item;
}


$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;



$stats = PRODUCTION::stats($date1, $date2, null);

$title = "BRICX | Rapport de production ";

$lots = [];
?>