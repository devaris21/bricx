<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");


$commandes = COMMANDE::findBy(["DATE(created) ="=>dateAjoute(), "etat_id !="=>ETAT::ANNULEE]);
$livraisons = LIVRAISON::programmee(dateAjoute());


$tableau = [];
foreach (PRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $prod) {
	$data = new \stdclass();
	$data->name = $prod->name();
	$data->image = $prod->image;
	$data->livrable = $prod->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), $agence->id);
	$data->attente = $prod->attente(PARAMS::DATE_DEFAULT, dateAjoute(1), $agence->id);
	$data->commande = $prod->commandee($agence->id);
	$tableau[] = $data;
}


$title = "BRICX | Tableau de bord";


$stats = [] // VENTE::stats(dateAjoute(-14), dateAjoute(), $agence->id);


?>