<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	session("date1", $date1);
	session("date2", $date2);
}


if ($action == "changer") {
	$data->setUrl("gestion", "production", "agences", $id);
	echo json_encode($data);
}