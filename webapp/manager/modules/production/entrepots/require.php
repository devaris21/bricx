<?php 
namespace Home;
use Faker\Factory;
unset_session("produits");
unset_session("commande-encours");
$faker = Factory::create();

if ($this->id != null) {
	$datas = AGENCE::findBy(["id ="=>$this->id]);
	if (count($datas) > 0) {
		$agence = $datas[0];
		$agence->actualise();

		$comptebanque = $agence->comptebanque;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$parfums = $typeproduits = $quantites = [];
		foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalVendu($date1, $date2, $agence->id, $item->id);
			$parfums[] = $item;
		}

		foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalVendu($date1, $date2, $agence->id, null, $item->id);
			$typeproduits[] = $item;
		}

		$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;

		$stats2 = PRODUCTION::stats($date1, $date2, $agence->id);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$mouvements = $comptebanque->fourni("mouvement", ["DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

		$transferts = TRANSFERTFOND::findBy(["comptebanque_id_source="=>$comptebanque->id, "DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

		$operations = OPERATION::findBy(["DATE(created) >= "=> dateAjoute(-7)]);
		$entrees = $depenses = [];
		foreach ($operations as $key => $value) {
			$value->actualise();
			if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
				$entrees[] = $value;
			}else{
				$depenses[] = $value;
			}
		}
		$stats3 = $comptebanque->stats($date1, $date2);

		$title = "BRICX | Vue générale sur ".$agence->name();
	}else{
		header("Location: ../master/dashboard");
	}
}else{
	header("Location: ../master/dashboard");
}
?>