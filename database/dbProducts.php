<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */


/**
 * dbProducts for BMAC-Warehouse
 * @author Noah Jensen
 * @version February 9, 2015
 */

include_once(dirname(__FILE__).'/../domain/Product.php');
include_once(dirname(__FILE__).'/../database/dbContributions.php');
include_once(dirname(__FILE__).'/../database/dbShipments.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function retrieve_dbProducts($product_id){
	$con=connect();
	$query="SELECT * FROM dbProducts WHERE product_id  = '".$product_id."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbProducts ".$product_id. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'], 
							$result_row['notes']);
	$con=null;
	return $theProd;
}

function retrieveWithFunding_dbProducts($product_id, $funding_source, $status){
	$con=connect();
	$query = "SELECT * FROM dbProducts WHERE product_id = '".$product_id;
	$query .= "' AND funding_source = '".$funding_source . "'";	
	if ($status!="")
		$query .=  " AND status = '".$status . "'";
	try {
		$result = $con->query($query);
	} catch (PDOException $p) {
		die("Could not retrieve from dbProducts ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
		$con=null;
		return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'], 
							$result_row['notes']);
	$con=null;
	return $theProd;
}



function retrieveByCode_dbProducts($product_code){
	$con=connect();
	$query="SELECT * FROM dbProducts WHERE product_code  = '".$product_code."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbProducts ".$product_code. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'], 
							$result_row['notes']);
	$con=null;
	return $theProd;
}

function getall_dbProducts(){
	$con=connect();
	$query = "SELECT * FROM dbProducts ORDER BY product_id";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbProducts ".$p->getMessage());
	}
	$theProds = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'],
							$result_row['notes']);
		$theProds[] = $theProd;
	}
	$con=null;
	return $theProds;
}

function getall_dbProduct_ids($fs){
	$con=connect();
	$query = "SELECT product_id,funding_source,unit_weight FROM dbProducts "; 
	if ($fs!="")
		$query .= " WHERE funding_source = '".$fs."'";
	$query .= " ORDER BY product_id,funding_source";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbProducts ".$p->getMessage());
	}
	$the_ids = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$the_ids[] = $result_row['product_id'].";".$result_row['funding_source'].";".$result_row['unit_weight'];
	}
	$con=null;
	return $the_ids;
}

// retrieve only those Products that match the criteria given in the arguments
function getonlythose_dbProducts($product_id, $funding_source, $status) {
	$con=connect();
	$query = "SELECT * FROM dbProducts WHERE product_id LIKE '%".$product_id."%'"; 
	if ($funding_source!="")
		$query .=		 " AND funding_source LIKE '%".$funding_source."%'"; 
    $query .= "  AND status LIKE '%".$status."%' ORDER BY status, product_id";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbProducts ".$p->getMessage());
    }
	$theProds = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
                          $result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'],
		                  $result_row['notes']);
		$theProds[] = $theProd;
	}
	$con=null;
	return $theProds;
}
// retrieve only those active Products whose id's begin with a particular string
function getproducts_beginningwith($string) {
	$con=connect();
	$query = "SELECT * FROM dbProducts WHERE product_id LIKE '".$string."%'" . 
			 "  AND status = 'active'" ;
    $query .= " ORDER BY product_id, funding_source";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbProducts ".$p->getMessage());
    }
	$theProds = array();
		
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theProd = new Product($result_row['product_id'],$result_row['product_code'], $result_row['funding_source'], $result_row['unit_weight'], $result_row['unit_price'], $result_row['initial_date'],
							$result_row['initial_stock'], $result_row['minimum_stock'], $result_row['history'], $result_row['current_stock'], $result_row['inventory_date'], $result_row['status'],
							$result_row['notes']);
		$theProds[] = $theProd;
	}
	$con=null;
	return $theProds;
}


function insert_dbProducts($Product){
	if(! $Product instanceof Product){
		return false;
	}
	$con=connect();
	$query = "SELECT * FROM dbProducts WHERE product_code = '" . $Product->get_product_code() . "'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not insert into dbProducts ".$p->getMessage());
	}
	if ($result->rowCount() > 0) {
		delete_dbProducts($Product->get_product_id(),$Product->get_funding_source(),$Product->get_status());
		$con=connect();
	} 
	$query = "INSERT INTO dbProducts VALUES ('".
				$Product->get_product_id()."','" .
				$Product->get_product_code()."','".
				$Product->get_funding_source()."','".
				$Product->get_unit_weight()."','".
				$Product->get_unit_price()."','".
				$Product->get_initial_date()."','".
				$Product->get_initial_stock()."','".
				$Product->get_minimum_stock()."','".
				implode(",",$Product->get_history())."','".
				$Product->get_current_stock()."','".
				$Product->get_inventory_date()."','".
				$Product->get_status()."','".
				$Product->get_notes()."');";
	try {
		$result = $con->query($query);
	} catch (PDOException $p) {
		die("Could not insert into dbProducts ". $p->getMessage());
	}
	if (!$result) {
		echo (" Unable to insert into dbProducts: " . $Product->get_product_id(). "\n");
		$con=null;
		return false;
	}
	$con=null;
	return true;
	
}

function retrieve_inventory($status, $funding_source){
	/* from date means beginning of history time period, to date is end 
	 */
	$products = getonlythose_dbProducts("", $funding_source, $status);
	$the_tens = array();
	foreach ($products as $product) {
		if (count($product->get_history())>0) // pull the most recent history for this product
			$last = end($product->get_history());
		else 
			$last = "00-01-01:0:0";              // if none, go back to the beginning of time and assume nothing on shelf
		$result = explode(":",$last);			// make an array
		$ship_items = count_shipments($product->get_product_id(), $funding_source, substr($last,0,8), ""); //ISSUE: ship and receives are inaccurate from history...
		$receive_items = count_receipts($product->get_product_id(), $funding_source, substr($last,0,8), "");
		$ship_details = explode(':',$ship_items);
		$receipt_details = explode(':',$receive_items);
		$current_weight = $result[2] - $ship_details[1] + $receipt_details[1];
		$the_ten = $product->get_product_id().":".$product->get_funding_source().":".$product->get_status().":".$result[0].":".$result[2].":".
			$ship_details[0].":".$ship_details[1].":".$receipt_details[0].":".$receipt_details[1].":".$current_weight;
		$the_tens[] = $the_ten;
	}
	sort($the_tens);
	return $the_tens;
}


function update_dbProducts($Product){
	if (! $Product instanceof Product) {
		echo ("Invalid argument for update_dbProduct function call");
		return false;
	}
	if (delete_dbProducts($Product->get_product_id(),$Product->get_funding_source(),$Product->get_status()))
	    return insert_dbProducts($Product);
	else {
		echo ("Unable to update dbProducts: ".$Product->get_product_id());
		return false;
	}
}

function delete_dbProducts($product_id, $funding_source, $status){
	$con=connect();
	$query = "DELETE FROM dbProducts WHERE product_id = '".$product_id . "' AND funding_source = '".$funding_source . "'"
					. " AND status = '".$status . "'";
	try {
		$result = $con->query($query);
	} catch (PDOException $p) {
		die("Could not delete product ".$p->getMessage());
	}
	$con=null;
	if (!$result) {
		echo ("Unable to delete from dbProducts: ".$product_id . $funding_source . $status);
		return false;
	}
	return true;
}

?>