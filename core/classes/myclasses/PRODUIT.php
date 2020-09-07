<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PRODUIT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $name;
	public $description;
	public $image;
	public $initial = 0;
	public $isActive = TABLE::NON;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->initial >= 0) {
			$data = $this->save();
			if ($data->status) {
				$this->uploading($this->files);
				foreach (ZONELIVRAISON::getAll() as $key => $zonelivraison) {
					$datas = PRIX_ZONELIVRAISON::findBy(["zonelivraison_id ="=>$zonelivraison->getId(), "produit_id ="=>$data->lastid]);
					if (count($datas) == 0) {
						$ligne = new PRIX_ZONELIVRAISON();
						$ligne->produit_id = $data->lastid;
						$ligne->zonelivraison_id = $zonelivraison->getId();
						$ligne->price = 0;
						$ligne->enregistre();
					}
				}


				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$datas = EXIGENCEPRODUCTION::findBy(["produit_id ="=>$data->lastid, "ressource_id ="=>$ressource->getId()]);
					if (count($datas) == 0) {
						$ligne = new EXIGENCEPRODUCTION();
						$ligne->produit_id = $data->lastid;
						$ligne->quantite_produit = 0;
						$ligne->ressource_id = $ressource->getId();
						$ligne->quantite_ressource = 0;
						$ligne->enregistre();
					}					
				}

				$ligne = new PAYE_PRODUIT();
				$ligne->produit_id = $data->lastid;
				$ligne->price = 0;
				$ligne->enregistre();

				$ligne = new PAYEFERIE_PRODUIT();
				$ligne->produit_id = $data->lastid;
				$ligne->price = 0;
				$ligne->enregistre();

			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner une quantité initiale supérieure ou egale à 0 !";
		}
		return $data;
	}



	public function uploading(Array $files){
		//les proprites d'images;
		$tab = ["image"];
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if ($file["tmp_name"] != "") {
					$image = new FICHIER();
					$image->hydrater($file);
					if ($image->is_image()) {
						$a = substr(uniqid(), 5);
						$result = $image->upload("images", "produits", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}





	public function stock(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$total = $this->production($date1, $date2, $agence_id) + $this->attente($date1, $date2, $agence_id) + $this->achat($date1, $date2, $agence_id) - 
		( $this->livree($date1, $date2, $agence_id) + $this->enLivraison($agence_id) + $this->perteLivraison($date1, $date2, $agence_id) + $this->perteAgence($date1, $date2, $agence_id));
		return $total;
	}



	public function production(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(ligneproduction.quantite) as quantite  FROM production, ligneproduction WHERE ligneproduction.produit_id = ? AND ligneproduction.production_id = production.id AND production.etat_id = ? AND production.created >= ? AND production.created <= ? $paras";
		$item = LIGNEACHATSTOCK::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEACHATSTOCK()]; }
		return $item[0]->quantite;
	}


	public function attente(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(ligneproduction.quantite) as quantite  FROM production, ligneproduction WHERE ligneproduction.produit_id = ? AND ligneproduction.production_id = production.id AND production.etat_id != ? AND production.etat_id != ? AND production.created >= ? AND production.created <= ? $paras";
		$item = LIGNEACHATSTOCK::execute($requette, [$this->id, ETAT::VALIDEE, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEACHATSTOCK()]; }
		return $item[0]->quantite;
	}


	public function achat(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(ligneachatstock.quantite_recu) as quantite  FROM achatstock, ligneachatstock WHERE ligneachatstock.produit_id = ? AND ligneachatstock.achatstock_id = achatstock.id AND achatstock.etat_id = ? AND achatstock.created >= ? AND achatstock.created <= ? $paras";
		$item = LIGNEACHATSTOCK::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEACHATSTOCK()]; }
		return $item[0]->quantite;
	}



	public function livree(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignelivraison, livraison WHERE lignelivraison.produit_id =  ? AND lignelivraison.livraison_id = livraison.id  AND livraison.etat_id = ? AND lignelivraison.created >= ? AND lignelivraison.created <= ? $paras ";
		$item = LIGNELIVRAISON::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		return $item[0]->quantite;
	}


	public function enLivraison(int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignelivraison, livraison WHERE lignelivraison.produit_id =  ? AND lignelivraison.livraison_id = livraison.id  AND livraison.etat_id = ? $paras ";
		$item = LIGNELIVRAISON::execute($requette, [$this->id, ETAT::ENCOURS]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		return $item[0]->quantite;
	}


	public function perteLivraison(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(perte) as perte  FROM lignelivraison, livraison WHERE lignelivraison.produit_id = ? AND lignelivraison.livraison_id = livraison.id AND livraison.etat_id != ? AND lignelivraison.created >= ? AND lignelivraison.created <= ? $paras ";
		$item = LIGNELIVRAISON::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		return $item[0]->perte;
	}




	public function perteAgence(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteagence WHERE perteagence.produit_id = ? AND perteagence.etat_id = ? AND DATE(perteagence.created) >= ? AND DATE(perteagence.created) <= ? $paras ";
		$item = PERTEAGENCE::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEAGENCE()]; }
		return $item[0]->quantite;
	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	public function vendu(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignelivraison, livraison WHERE lignelivraison.produit_id = ? AND lignelivraison.livraison_id = livraison.id AND livraison.etat_id != ? AND lignelivraison.created >= ? AND lignelivraison.created <= ? $paras ";
		$item = LIGNELIVRAISON::execute($requette, [$this->id,  ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		return $item[0]->quantite;
	}



	public static function totalVendu($date1, $date2, int $agence_id=null){
		$paras = "";
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$paras.= " AND livraison.created BETWEEN '$date1' AND '$date2'";
		$requette = "SELECT lignelivraison.* FROM groupecommande, livraison, lignelivraison, produit WHERE lignelivraison.livraison_id = livraison.id AND livraison.groupecommande_id = groupecommande.id AND lignelivraison.produit_id = produit.id AND $paras";
		$datas = LIGNELIVRAISON::execute($requette, []);
		return comptage($datas, "price", "somme");
	}



	public static function totalProduit($date1, $date2, int $agence_id=null){
		$paras = "";
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$paras.= " AND production.created BETWEEN '$date1' AND '$date2'";
		$requette = "SELECT ligneproduction.* FROM ligneproduction, production, produit WHERE ligneproduction.production_id = production.id AND ligneproduction.produit_id = produit.id $paras";
		$datas = LIGNEPRODUCTION::execute($requette, []);
		return comptage($datas, "quantite", "somme");
	}



	public static function totalAchat(string $date1, string $date2, int $agence_id = null){
		$paras = "";
		if ($agence_id != null) {
			$paras.= "AND agence_id = $agence_id ";
		}
		$requette = "SELECT SUM(ligneachatstock.quantite) as quantite  FROM achatstock, ligneachatstock WHERE ligneachatstock.produit_id = ? AND ligneachatstock.achatstock_id = achatstock.id AND achatstock.etat_id != ? AND achatstock.created >= ? AND achatstock.created <= ? $paras";
		$item = LIGNEACHATSTOCK::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEACHATSTOCK()]; }
		return $item[0]->quantite;
	}



	public function commandee(int $agence_id = null){
		$total = 0;
		$datas = GROUPECOMMANDE::encours();
		foreach ($datas as $key => $comm) {
			if ($comm->agence_id == $agence_id) {
				$total += $comm->reste($this->id);
			}
		}
		return $total;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	public function montantStock(int $agence_id = null){
		$this->actualise();
		if ($agence_id == null) {
			return $this->enBoutique(dateAjoute()) * $this->prix->price;
		}else{
			return $this->enBoutique(dateAjoute(), $agence_id) * $this->prix->price;
		}
	}


	public function montantVendu(string $date1, string $date2, int $agence_id = null){
		$this->actualise();
		if ($agence_id == null) {
			return ($this->vendu($date1, $date2) + $this->livree($date1, $date2) )* $this->prix->price ;
		}else{
			return ($this->vendu($date1, $date2, $agence_id) + $this->livree($date1, $date2, $agence_id) )* $this->prix->price ;
		}
	}



	public static function ruptureBoutique(int $agence_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $agence_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
	}


	public static function ruptureEntrepot(int $agence_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), EMBALLAGE::PRIMAIRE, $agence_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
	}



	public function exigence(int $quantite, int $ressource_id){
		$datas = EXIGENCEPRODUCTION::findBy(["produit_id ="=>$this->id, "ressource_id ="=>$ressource_id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			if ($item->quantite_produit == 0) {
				return 0;
			}
			return ($quantite * $item->quantite_ressource) / $item->quantite_produit;
		}
		return 0;
	}



	public function coutProduction(String $type, int $quantite){
		if(isJourFerie(dateAjoute())){
			$datas = PAYEFERIE_PRODUIT::findBy(["produit_id ="=>$this->id]);
		}else{
			$datas = PAYE_PRODUIT::findBy(["produit_id ="=>$this->id]);
		}
		if (count($datas) > 0) {
			$ppr = $datas[0];
			switch ($type) {
				case 'production':
				$prix = $ppr->price;
				break;

				case 'rangement':
				$prix = $ppr->price_rangement;
				break;

				case 'vente':
				$prix = $ppr->price_vente;
				break;

				default:
				$prix = $ppr->price;
				break;
			}
			return $quantite * $prix;
		}
		return 0;
	}



	public function changerMode(){
		if ($this->isActive == TABLE::OUI) {
			$this->isActive = TABLE::NON;
		}else{
			$this->isActive = TABLE::OUI;
			$pro = PRODUCTION::today();
			$datas = LIGNEPRODUCTION::findBy(["production_id ="=>$pro->id, "produit_id ="=>$pdv->id]);
			if (count($datas) == 0) {
				$ligne = new LIGNEPRODUCTION();
				$ligne->production_id = $pro->id;
				$ligne->produit_id = $pdv->id;
				$ligne->enregistre();
			}			
		}
		return $this->save();
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>