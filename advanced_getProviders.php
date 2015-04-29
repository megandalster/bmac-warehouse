<?php 
include_once('database/dbProviders.php');
include_once('domain/Provider.php');
$provider_ids = getall_dbProvider_ids();
//var_dump($product_ids);
if (isset($_GET['q'])) {
	show_hint($provider_ids);
}

function show_hint($names) {
	$q=$_GET['q'];
	$hint = array();
	if (strlen($q) > 0) {
		for($i=0; $i <count($names); $i++) {
			if (strtolower($q) == strtolower(substr($names[$i], 0, strlen($q)))){
				$hint[] = $names[$i];
			}
		}
	}
	echo json_encode($hint);
}
?>
