<?php 
namespace Home;

//n'oublie pas de configurer la date par defaut PARAMS
//n'oublie pas d'importer la base de données des marques de vehicules

$datas = ["Au magasin", "Dans tout Bassam"];
foreach ($datas as $key => $value) {
	$item = new ZONEDEVENTE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}

$item = new BOUTIQUE();
$item->name = "Boutique principale";
$item->comptebanque_id = COMPTEBANQUE::COURANT;
$item->setProtected(1);
$item->save();

$item = new AGENCE();
$item->name = "Usine principale";
$item->comptebanque_id = COMPTEBANQUE::COURANT;
$item->setProtected(1);
$item->save();


$datas = ["Vente Directe", "Prospection", "Livraison Commande", "Vente en Cave"];
foreach ($datas as $key => $value) {
	$item = new TYPEVENTE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$datas = ["Prospection par commercial", "livraison de commande"];
foreach ($datas as $key => $value) {
	$item = new TYPEPROSPECTION();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$datas = ["Entrée de caisse", "Sortie de caisse"];
foreach ($datas as $key => $value) {
	$item = new TYPEOPERATIONCAISSE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}




$item = new TYPEBIEN();
$item->name = "Magasin / Entrepot / Usine";
$item->min = 15;
$item->max = 50;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name = "Meubles / Mobiliers";
$item->min = 5;
$item->max = 10;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name = "Véhicules";
$item->min = 3;
$item->max = 5;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name = "Materiels industriels / Outillages";
$item->min = 5;
$item->max = 10;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name = "Materiels informatiques";
$item->min = 2;
$item->max = 5;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name = "Brevets";
$item->min = 3;
$item->max = 5;
$item->setProtected(1);
$item->save();


$item = new TYPEBIEN();
$item->name ="Logiciels / Sites internet";
$item->min = 2;
$item->max = 3;
$item->setProtected(1);
$item->save();



$datas = ["Immobilisation corporelle", "Immobilisation incorporelle", "Immobilisation financière"];
foreach ($datas as $key => $value) {
	$item = new TYPEIMMOBILISATION();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$datas = ["Dépôt", "Retrait"];
foreach ($datas as $key => $value) {
	$item = new TYPEMOUVEMENT();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$datas = ["Caisse courante"];
foreach ($datas as $key => $value) {
	$item = new COMPTEBANQUE();
	$item->name = $value;
	$item->etablissement = "Caisse principale";
	$item->setProtected(1);
	$item->save();
}

$datas = ["Amortissement linéaire", "Amortissement dégressif"];
foreach ($datas as $key => $value) {
	$item = new TYPEAMORTISSEMENT();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}



$datas = ["Bissap", "Gingembre", "Passion", "Tamarin", "Citron", "Baobab"];
foreach ($datas as $key => $value) {
	$item = new PARFUM();
	$item->name = $value;
	$item->setProtected(1);
	$item->enregistre();
}

$datas = ["Jus sucré", "Sans sucre"];
foreach ($datas as $key => $value) {
	$item = new TYPEPRODUIT();
	$item->name = $value;
	$item->unite = "Litre" ;
	$item->abbr = "L" ;
	$item->setProtected(1);
	$item->enregistre();
}

$datas = [0.25, 0.33, 0.5, 1];
foreach ($datas as $key => $value) {
	$item = new QUANTITE();
	$item->name = $value;
	$item->setProtected(1);
	$item->enregistre();
}


$datas = ["Entreprise", "Particulier"];
foreach ($datas as $key => $value) {
	$item = new TYPECLIENT();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}

$item = new SEXE();
$item->name = "Homme";
$item->abreviation = "H";
$item->setProtected(1);
$item->save();

$item = new SEXE();
$item->name = "Femme";
$item->abreviation = "F";
$item->setProtected(1);
$item->save();


$datas = ["master", "manager", "agence", "agence", "config",
 "production", "ventes", "stock", "caisse", "rapports",
  "modifier-supprimer", "roles", "mycompte"];
foreach ($datas as $key => $value) {
	$item = new ROLE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}



$datas = ["Incendie", "Peremption", "Dégats-endommagement", "Vol"];
foreach ($datas as $key => $value) {
	$item = new TYPEPERTE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$item = new PARAMS();
$item->societe = "Devaris 21";
$item->email = "info@devaris21.com";
$item->devise = "Fcfa";
$item->tva = 0;
$item->seuilCredit = 0;
$item->minImmobilisation = 350000;
$item->setProtected(1);
$item->enregistre();


$item = new MYCOMPTE();
$item->identifiant = strtoupper(substr(uniqid(), 5, 7));
$item->tentative = 0;
$item->expired = dateAjoute(7);
$item->setProtected(1);
$item->enregistre();



$item = new MODEPAYEMENT();
$item->name = "Espèces";
$item->initial = "ES";
$item->etat_id = ETAT::VALIDEE;
$item->setProtected(1);
$item->save();

$item = new MODEPAYEMENT();
$item->name = "Prelevement sur acompte";
$item->initial = "PA";
$item->etat_id = ETAT::VALIDEE;
$item->setProtected(1);
$item->save();

$item = new MODEPAYEMENT();
$item->name = "Chèque";
$item->initial = "CH";
$item->etat_id = ETAT::ENCOURS;
$item->setProtected(1);
$item->save();

$item = new MODEPAYEMENT();
$item->name = "Virement banquaire";
$item->initial = "VB";
$item->etat_id = ETAT::ENCOURS;
$item->setProtected(1);
$item->save();

$item = new MODEPAYEMENT();
$item->name = "Mobile money";
$item->initial = "MM";
$item->etat_id = ETAT::ENCOURS;
$item->setProtected(1);
$item->save();



$item = new ETAT();
$item->name = "Annulé";
$item->class = "danger";
$item->setProtected(1);
$item->save();

$item = new ETAT();
$item->name = "En cours";
$item->class = "warning";
$item->setProtected(1);
$item->save();

$item = new ETAT();
$item->name = "Partiellement";
$item->class = "info";
$item->setProtected(1);
$item->save();

$item = new ETAT();
$item->name = "Validé";
$item->class = "success";
$item->setProtected(1);
$item->save();



$item = new DISPONIBILITE();
$item->name = "Indisponible";
$item->class = "danger";
$item->setProtected(1);
$item->save();

$item = new DISPONIBILITE();
$item->name = "Libre";
$item->class = "warning";
$item->setProtected(1);
$item->save();

$item = new DISPONIBILITE();
$item->name = "En mission";
$item->class = "info";
$item->setProtected(1);
$item->save();



$datas = ["Prix normal", "Prix de gros"];
foreach ($datas as $key => $value) {
	$item = new TYPEBAREME();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}


$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::ENTREE;
$item->name = "Retour de fonds par le fournisseur";
$item->setProtected(1);
$item->save();


$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::ENTREE;
$item->name = "Autre entrée en caisse";
$item->setProtected(1);
$item->save();



$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::SORTIE;
$item->name = "Frais de Transport";
$item->setProtected(1);
$item->save();

$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::SORTIE;
$item->name = "Main d'oeuvre de production";
$item->setProtected(1);
$item->save();

$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::SORTIE;
$item->name = "Réglement de facture de reparation / d'entretien";
$item->setProtected(1);
$item->save();

$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::SORTIE;
$item->name = "Retour de fonds au client";
$item->setProtected(1);
$item->save();


$item = new CATEGORIEOPERATION();
$item->typeoperationcaisse_id = TYPEOPERATIONCAISSE::SORTIE;
$item->name = "Autre dépense";
$item->setProtected(1);
$item->save();



$item = new EMPLOYE();
$item->name = "Super Administrateur";
$item->email = "info@email.com";
$item->adresse = "...";
$item->contact = "...";
$item->login = "root";
$item->password = "5e9795e3f3ab55e7790a6283507c085db0d764fc";
$item->setProtected(1);
$data = $item->save();
foreach (ROLE::getAll() as $key => $value) {
	$tr = new ROLE_EMPLOYE();
	$tr->employe_id = $data->lastid;
	$tr->role_id = $value->id;
	$tr->setProtected(1);
	$tr->enregistre();
}



$datas = ["standart"];
foreach ($datas as $key => $value) {
	$item = new TYPEVEHICULE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();

	$item = new TYPETRANSMISSION();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();


	$item = new ENERGIE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();

	$item = new GROUPEMANOEUVRE();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();

	$item = new TYPESUGGESTION();
	$item->name = $value;
	$item->setProtected(1);
	$item->save();
}

?>