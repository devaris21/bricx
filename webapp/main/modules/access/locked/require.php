<?php 
namespace Home;
$title = "BRICX | Session vérouillée ";

$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
if (count($datas) >0) {
	$employe = $datas[0];
	$employe->actualise();
	session("page_session", 1);
}else{
	header("Location: ../access/login");
}

?>