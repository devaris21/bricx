<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($action === "production") {
		$production = PRODUCTION::today();
		$test = true;
		foreach (RESSOURCE::getAll() as $key => $ressource) {
			$datas = $production->fourni("ligneconsommation", ["ressource_id ="=>$ressource->getId()]);
			if (count($datas) == 1) {
				$ligne = $datas[0];
				if (intval($_POST["conso-".$ressource->getId()]) > ($ressource->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("agence_connecte_id")) + $ligne->consommation) ) {
					$test = false;
					break;
				}
			}
		}
		if ($test) {
			$cout = 0;
			$production->fourni("ligneproduction");
			foreach ($production->ligneproductions as $cle => $ligne) {
				$ligne->quantite = intval($_POST["prod-".$ligne->produit_id]);
				$ligne->save();
				$ligne->actualise();
				$cout += $ligne->produit->coutProduction("production", $ligne->production);
			}



			$production->fourni("perteagence");
			foreach ($production->perteagences as $cle => $ligne) {
				$ligne->quantite = intval($_POST["perte-".$ligne->produit_id]);
				$ligne->save();
			}



			$production->fourni("ligneconsommation");
			foreach ($production->ligneconsommations as $cle => $ligne) {
				$ligne->quantite = intval($_POST["conso-".$ligne->ressource_id]);
				$ligne->save();
			}


			$production->hydrater($_POST);
			$production->etat_id = ETAT::PARTIEL;
			$production->coutproduction = $montant;
			$production->employe_id = getSession("employe_connecte_id");
			$data = $production->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas consommé plus de quantité d'une ressource que ce que vous n'en possédez !";
		}

	echo json_encode($data);
}








if ($action == "annulerMiseenagence") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = MISEENBOUTIQUE::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$prospection = $datas[0];
				$data = $prospection->annuler();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
			}
		}else{
			$data->status = false;
			$data->message = "Votre mot de passe ne correspond pas !";
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas effectué cette opération !";
	}
	echo json_encode($data);
}




if ($action == "validerMiseenagence") {
	$id = getSession("miseenagence_id");
	$datas = MISEENBOUTIQUE::findBy(["id ="=>$id, "etat_id = "=>ETAT::ENCOURS]);
	if (count($datas) > 0) {
		$mise = $datas[0];
		$mise->actualise();
		$mise->fourni("lignemiseenagence");

		$produits = explode(",", $tableau);
		foreach ($produits as $key => $value) {
			$lot = explode("-", $value);
			$array[$lot[0]] = end($lot);
		}

		if (count($produits) > 0) {
			$tests = $array;
			foreach ($tests as $key => $value) {
				foreach ($mise->lignemiseenagences as $cle => $lgn) {
					if (($lgn->id == $key) && ($lgn->quantite_depart >= $value)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($array as $key => $value) {
					foreach ($mise->lignemiseenagences as $cle => $lgn) {
						if ($lgn->id == $key) {
							$lgn->quantite = $value;
							$lgn->perte = $lgn->quantite_depart - $value;
							$lgn->save();
							break;
						}
					}					
				}
				$mise->hydrater($_POST);
				$data = $mise->valider();
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits, certaines sont incorrectes !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}