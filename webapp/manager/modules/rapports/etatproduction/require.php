<?php 
namespace Home;

if ($this->id != "") {
	$tab = explode("@", $this->id);
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = PARAMS::DATE_DEFAULT;
	$date2 = dateAjoute(1);
}

$pdvs = PRODUIT::getAll();
foreach ($pdvs as $key => $pdv) {
	$pdv->actualise();
	$pdv->production = $pdv->production($date1, $date2);
	$pdv->livraison = $pdv->vendu($date1, $date2);
	$pdv->perte = $pdv->perte($date1, $date2);

	foreach (RESSOURCE::getAll() as $key => $ressource) {
		$name = trim($ressource->name());
		$pdv->$name = $pdv->exigence(($pdv->production + $pdv->perte), $ressource->id);
		$a = "perte-$name";
		$pdv->$a = $pdv->exigence($pdv->perte, $ressource->id);
	}
}

$perte = comptage($pdvs, "perte", "somme");
if ($perte > 0) {
	$pertelivraison = round(((PROSPECTION::perte($date1, $date2) / $perte) * 100),2);
}else{
	$pertelivraison = 0;
}

$productions = PRODUCTION::findBy(["ladate >="=>$date1, "ladate <= "=>$date2]);

$tricycles = [];
//$tricycles = VENTE::findBy(["DATE(datelivraison) >="=>$date1, "DATE(datelivraison) <= "=>$date2, "etat_id ="=>ETAT::VALIDEE, "vehicule_id ="=>VEHICULE::TRICYCLE]);


$ressources = RESSOURCE::getAll();
usort($pdvs, "comparerPerte");

$title = "BRICX | Etat récapitulatif des produits ";
?>