<?php 

namespace Home;

if ($this->id != null) {
	$datas = MISEENBOUTIQUE::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$mise = $datas[0];
		$mise->actualise();

		$mise->fourni("lignemiseenagence");

		$title = "BRICX | Bon de livraison ";
		
	}else{
		header("Location: ../production/miseenagence");
	}
}else{
	header("Location: ../production/miseenagence");
}

?>