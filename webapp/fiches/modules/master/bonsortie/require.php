<?php 

namespace Home;

if ($this->id != null) {
	$datas = PROSPECTION::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$prospection = $datas[0];
		$prospection->actualise();

		$prospection->fourni("ligneprospection");

		$title = "BRICX | Bon de sortie ";
		
	}else{
		header("Location: ../production/prospections");
	}
}else{
	header("Location: ../production/prospections");
}

?>