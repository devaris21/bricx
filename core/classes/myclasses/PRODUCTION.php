<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PRODUCTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $comment = "";
	public $coutproduction = 0;
	public $agence_id = AGENCE::PRINCIPAL;
	public $employe_id = 0;
	public $etat_id = ETAT::ENCOURS;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->agence_id = getSession("agence_connecte_id");
		$datas = AGENCE::findBy(["id ="=>$this->agence_id]);
		if (count($datas) == 1) {
			$this->reference = "PROD/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
		return $data;
	}




	public static function today(){
		$datas = static::findBy(["ladate ="=>dateAjoute()]);
		if (count($datas) > 0) {
			$pro = $datas[0];
		}else{
			$pro = new PRODUCTION();
			$data = $pro->enregistre();
		}

		return $pro;
	}




	public static function stats(string $date1 = "2020-04-01", string $date2, int $agence_id = null){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		if ($agence_id == null) {
			while ( $index <= $date2 ) {
				
				$data = new \stdclass;
				$data->year = date("Y", strtotime($index));
				$data->month = date("m", strtotime($index));
				$data->day = date("d", strtotime($index));
				$data->nb = $nb;
			////////////

				$data->total = PRODUIT::totalProduit($date1, $index);
				// $data->marge = 0 ;

				$tableaux[] = $data;
			///////////////////////

				$index = dateAjoute1($index, ceil($nb));
			}
		}else{
			while ( $index <= $date2 ) {

				$data = new \stdclass;
				$data->year = date("Y", strtotime($index));
				$data->month = date("m", strtotime($index));
				$data->day = date("d", strtotime($index));
				$data->nb = $nb;
			////////////

				$data->total = PRODUIT::totalProduit($date1, $index, $agence_id);
				// $data->marge = 0 ;

				$tableaux[] = $data;
			///////////////////////

				$index = dateAjoute1($index, ceil($nb));
			}
		}
		return $tableaux;
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>