<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class APPROVISIONNEMENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $montant = 0;
	public $avance = 0;
	public $reste = 0;
	public $transport;
	public $reglementfournisseur_id ;
	public $fournisseur_id;
	public $agence_id;
	public $employe_id;
	public $etat_id;
	public $employe_id_reception;
	public $comment;
	public $datelivraison;

	public $acompteFournisseur = 0;
	public $detteFournisseur = 0;
	
	public function enregistre(){
		$data = new RESPONSE;
		$datas = FOURNISSEUR::findBy(["id ="=>$this->fournisseur_id]);
		if (count($datas) == 1) {
			if ($this->montant >= 0 ) {
				$this->reference = "APP/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
				$this->employe_id = getSession("employe_connecte_id");
				$this->agence_id = getSession("agence_connecte_id");
				$data = $this->save();
				if ($data->status && $this->transport > 0) {
					$mouvement = new OPERATION();
					$mouvement->montant = $this->transport;
					$mouvement->categorieoperation_id = CATEGORIEOPERATION::FRAISTRANSPORT;
					$mouvement->modepayement_id = MODEPAYEMENT::ESPECE;
					$mouvement->comment = "Frais de transport pour l'approvisionnement d'emballage N° ".$this->reference;
					$data = $mouvement->enregistre();
				}
			}else{
				$data->status = false;
				$data->message = "Le montant de la commande n'est pas correcte !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}


	public static function encours(){
		return static::findBy(["etat_id ="=>ETAT::ENCOURS, "visibility = "=>1]);
	}
	

	public function annuler(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::ANNULEE;
			$this->datelivraison = date("Y-m-d H:i:s");
			$this->historique("L'approvisionnement en reference $this->reference vient d'être annulée !");
			$data = $this->save();
			if ($data->status) {
				$this->actualise();
				if ($this->operation_id > 0) {
					$this->operation->supprime();
					$this->fournisseur->dette -= $this->montant - $this->avance;
					$this->fournisseur->save();
				}else{
						//paymenet par prelevement banquaire
					$this->fournisseur->acompte += $this->avance;
					$this->fournisseur->dette -= $this->montant - $this->avance;
					$this->fournisseur->save();
				}
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cet approvisionnement !";
		}
		return $data;
	}



	public function terminer(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::VALIDEE;
			$this->employe_id_reception = getSession("employe_connecte_id");
			$this->datelivraison = date("Y-m-d H:i:s");
			$this->historique("L'approvisionnement en reference $this->reference vient d'être terminé !");
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cet approvisionnement !";
		}
		return $data;
	}


	
	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>