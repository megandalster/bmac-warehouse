<?php 
include_once('database/dbProducts.php');
include_once('domain/Product.php');
$product_ids = getall_dbProduct_ids("");
//var_dump($product_ids);
if (isset($_GET['q'])) {
	show_hint($product_ids);
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
