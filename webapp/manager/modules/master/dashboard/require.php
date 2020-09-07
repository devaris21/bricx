<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$params = PARAMS::findLastId();

COMMERCIAL::finDuMois();
GROUPECOMMANDE::etat();
VENTE::ResetProgramme();

$title = "BRICX | Tableau de bord";

$tableau = [];
$rupture = 0;
// foreach (PRODUIT::getAll() as $key => $produit) {
// 	$tab = [];
// 	foreach ($produit->fourni('prixdevente', ["isActive ="=>TABLE::OUI]) as $key => $pdv) {
// 		$pdv->actualise();
// 		$data = new \stdclass();
// 		$data->name = $pdv->produit->name()." // ".$pdv->prix->price()/*." ".$params->devise*/;
// 		$data->prix = $pdv->prix->price()." ".$params->devise;
// 		$data->quantite = $pdv->quantite->name();
// 		$data->agence = $data->commande = $data->stock = 0;
// 		$data->agence = $pdv->enBoutique(dateAjoute());
// 		$data->commande = $pdv->commandee();
// 		$data->stock = $pdv->enEntrepot(dateAjoute());
// 		$data->rupture = false;
// 		if ($data->agence <= $params->ruptureStock || $data->stock <= $params->ruptureStock) {
// 			$data->rupture = true;
// 			$rupture++;
// 		}	
// 		$tab[] = $data;
// 	}
// 	$tableau[$produit->id] = $tab;
// }

for ($i=0; $i < 30; $i++) { 
	$date = dateAjoute(-30 + $i);
	$stats[] = 2;
}

$depenses = OPERATION::sortie(dateAjoute() , dateAjoute(+1));

$stats = VENTE::stats2($date1, $date2);


?>