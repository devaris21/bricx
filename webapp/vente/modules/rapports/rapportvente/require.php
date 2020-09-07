<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $agence->id, $item->id);
		$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $agence->id, null, $item->id);
		$typeproduits[] = $item;
}

foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $agence->id, null, null, $item->id);
		$quantites[] = $item;
}



$stats = VENTE::stats($date1, $date2, $agence->id);

$title = "BRICX | Rapport de vente ";

$lots = [];
?>