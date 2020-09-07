<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class GROUPECOMMANDE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $client_id;
	public $agence_id;
	public $etat_id = ETAT::ENCOURS;
	

	public function enregistre(){
		$this->agence_id = getSession("agence_connecte_id");
		return $data = $this->save();
	}


	public function resteAPayer(){
		$datas = $this->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]);
		return comptage($datas, "reste", "somme");
	}


	public static function etat(){
		foreach (static::findBy(["etat_id ="=>ETAT::ENCOURS]) as $key => $groupe) {
			$test = false;
			foreach ($groupe->toutesLesLignes() as $key => $ligne) {
				if ($groupe->reste($ligne->produit_id, $ligne->emballage_id) > 0) {
					$test = true;
					break;
				}
			}
			if (!$test) {
				$groupe->etat_id = ETAT::VALIDEE;
				$groupe->save();
			}
		}
	} 


	public function reste(int $produit_id){
		$total = 0;

		$requette = "SELECT SUM(quantite) as quantite FROM lignecommande, commande WHERE lignecommande.produit_id = ? AND lignecommande.commande_id = commande.id AND commande.groupecommande_id = ? AND commande.etat_id != ? GROUP BY produit_id";
		$item = LIGNECOMMANDE::execute($requette, [$produit_id, $this->id, ETAT::ANNULEE, ]);
		if (count($item) < 1) {$item = [new LIGNECOMMANDE()]; }
		$total += $item[0]->quantite;

		$requette = "SELECT SUM(quantite_livree) as quantite FROM lignelivraison, livraison WHERE livraison.groupecommande_id = ? AND lignelivraison.produit_id = ? AND  lignelivraison.livraison_id = livraison.id AND livraison.etat_id != ? GROUP BY produit_id";
		$item = LIGNELIVRAISON::execute($requette, [$this->id, $produit_id, ETAT::ANNULEE]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		$total -= $item[0]->quantite;

		return $total;
	}


	public function toutesLesLignes(){
		$requette = "SELECT produit_id, SUM(quantite) as quantite FROM lignecommande, commande WHERE lignecommande.commande_id = commande.id AND commande.groupecommande_id =  ? AND commande.etat_id != ? GROUP BY produit_id";
		return LIGNECOMMANDE::execute($requette, [$this->id, ETAT::ANNULEE]);
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>