<?php 
include_once('database/dbCustomers.php');
include_once('domain/Customer.php');
$customer_ids = getall_dbCustomer_ids();
//var_dump($customer_ids);
if (isset($_GET['q'])) {
	show_hint($customer_ids);
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
