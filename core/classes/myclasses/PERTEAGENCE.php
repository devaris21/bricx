<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PERTEAGENCE extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $production_id;
	public $produit;
	public $produit_id;
	public $ressource_id;
	public $quantite;
	public $comment;
	public $agence_id;
	public $employe_id;
	public $etat_id = ETAT::VALIDEE;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUCTION::findBy(["id ="=>$this->production_id]);
		if (count($datas) == 1) {
			if ($this->quantite > 0) {

				if ($this->produit_id != null) {
					$item = new PRODUIT;
					$item->id = $this->produit_id;
					$item->actualise();
					$stock = $item->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("agence_connecte_id"));

				}elseif ($this->ressource_id != null) {
					$item = new RESSOURCE;
					$item->id = $this->ressource_id;
					$item->actualise();
					$stock = $item->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("agence_connecte_id"));

				}

				if ($stock >= $this->quantite) {
					$this->employe_id = getSession("employe_connecte_id");
					$this->agence_id = getSession("agence_connecte_id");
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "La quantité perdue est plus élévé que celle que vous avez effectivement !";
				}
			}else{
				$data->status = false;
				$data->message = "Erreur sur la quantité perdue !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors  de l'opération, veuillez recommencer !";
		}
		return $data;
	}


	public function name(){
		$this->actualise();
		if ($this->produit != null) {
			return $this->produit->name();

		}elseif ($this->ressource_id != null) {
			return $this->ressource->name();

		}
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>