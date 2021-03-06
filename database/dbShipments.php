<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of BMAC-Warehouse, which is free software. It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbShipments for BMAC-Warehouse
 * @author Dylan Martin
 * @version 13 February 2015
 */

include_once(dirname(__FILE__).'/../domain/Shipment.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function retrieve_dbShipments($customer_id){
	$con=connect();
	$query="SELECT * FROM dbShipments WHERE customer_id  = '".$customer_id."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ".$customer_id. " ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
							$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);
	$con=null;
	return $theShipment;
	
}

function retrieve_dbShipmentsDate($ship_date){
	$con=connect();
	$query="SELECT * FROM dbShipments WHERE ship_date  = '".$ship_date."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ". $p->getMessage());
	}
	if($result->rowCount()!== 1){
	    $con=null;
	    return false;
	}
	$result_row = $result->fetch(PDO::FETCH_ASSOC);
	$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
							$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);
	$con=null;
	return $theShipment;
	
}


function getall_dbShipments(){
	$con=connect();
	$query="SELECT * FROM dbShipments ORDER BY funds_source";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ".$p->getMessage());
	}
	$theVols = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theVol = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);	
		$theVols[] = $theVol;
	}
	$con=null;
	return $theVols;
}


function getonlythose_dbShipments($customer_id, $ship_date1, $ship_date2, $ship_items) {
	$con=connect();
	$query = "SELECT * FROM dbShipments WHERE customer_id LIKE '%".$customer_id."%'";
	if($ship_date1!="") 
		$query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2!="") 
		$query.= " AND ship_date <= '".$ship_date2.":99:99"."'"; 
	$query .= " AND ship_items LIKE '%".$ship_items."%'" ;
	$query .= " ORDER BY ship_date DESC";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ".$p->getMessage());
	}
	$theShipments = array();

	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], 
		$result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], 
		$result_row['invoice_no'], $result_row['notes']);	
		$theShipments[] = $theShipment;
	}
	$con=null;
	return $theShipments;
}

// variation that matches the customer id exactly for use with customer report
function getonlythose_dbShipments2($customer_id, $ship_date1, $ship_date2, $funds_source) { 
	$con=connect();
	$query = "SELECT * FROM dbShipments WHERE customer_id = '".$customer_id."'";
	if($ship_date1) $query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2) $query.=	" AND ship_date <= '".$ship_date2.":99:99"."'"; 
    if($funds_source) $query.=	" AND funds_source = '".$funds_source."'"; 
    $query .= " ORDER BY ship_date DESC";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbShipments ".$p->getMessage());
    }
    $theShipments = array();
		
    while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], 
		$result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], 
		$result_row['invoice_no'], $result_row['notes']);	
		$theShipments[] = $theShipment;
	}
	$con=null;
	return $theShipments;
}

// retrieve shipments that match criteria and sort by customer_id and date
function retrieve_shipments($funds_source, $ship_date1, $ship_date2) { 
	$con=connect();
	$query = "SELECT * FROM dbShipments WHERE funds_source LIKE '%".$funds_source."%'";
	if($ship_date1!="") $query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2!="") $query.=	" AND ship_date <= '".$ship_date2.":99:99"."'"; 
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ".$funds_source. " ". $p->getMessage());
	}
	$thequads = array();
    $count = 0;	
    while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$items = explode(",",$result_row['ship_items']);
		foreach ($items as $item) {
			$it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
			$thequad = $it[0].":".substr($result_row['ship_date'],0,8).":".$result_row['customer_id'].":".$it[2];
			$thequads[] = $thequad;
		}
	    $count++;
	}
	$con=null;
	sort($thequads);
	return $thequads;
}

function insert_dbShipments($Shipment){
	if(! $Shipment instanceof Shipment){
		return false;
	}
	$con=connect();
	$query = "INSERT INTO dbShipments VALUES ('".
				$Shipment->get_customer_id()."','" .
				$Shipment->get_funds_source()."','".
				$Shipment->get_ship_date()."','".
				$Shipment->get_ship_via()."','".
				implode(',',$Shipment->get_ship_items()). "','".
				$Shipment->get_ship_rate()."','".
				$Shipment->get_total_weight()."','".
				$Shipment->get_total_price()."','".
				$Shipment->get_invoice_date()."','".
				$Shipment->get_invoice_no()."','".
				$Shipment->get_notes().
	            "');";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not insert into dbShipments ".$p->getMessage());
	}
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbShipments: " . $Shipment->get_customer_id(). "\n");
		$con=null;
		return false;
	}
	$con=null;
	return true;

}

function update_dbShipments($Shipment){
	if (! $Shipment instanceof Shipment) {
		echo ("Invalid argument for update_dbShipment function call");
		return false;
	}
	if (delete_dbShipmentsDate($Shipment->get_ship_date()))
	return insert_dbShipments($Shipment);
	else {
		echo (mysql_error()."unable to update dbShipments table: ".$Shipment->get_ship_date());
		return false;
	}
}

function delete_dbShipmentsDate($ship_date){
	$con=connect();
	$query = "DELETE FROM dbShipments WHERE ship_date = '".$ship_date."'";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not delete shipment ".$p->getMessage());
	}
	$con=null;
	if (!$result) {
		echo (" unable to delete from dbShipments: ".$ship_date);
		return false;
	}
	return true;
}

// count shipments for a given product and payment source within the date range
// return the pair "no_shipments:total_wt" as a character string
function count_shipments($product_id, $payment_source, $ship_date1, $ship_date2) { 
	$con=connect();
	$query = "SELECT * FROM dbShipments WHERE funds_source LIKE '%".$payment_source."%'";
  	$query.= " AND ship_items LIKE '%".$product_id."%' ";
	if($ship_date1!="") $query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2!="") $query.= " AND ship_date <= '".$ship_date2.":99:99"."'"; 
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbShipments ".$p->getMessage());
	}
	$total_weight = 0;
	$item_count = 0;
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$items = explode(",",$result_row['ship_items']);
		foreach ($items as $item) {
			$it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
			if ($it[0]==$product_id) {
			    $total_weight += $it[2];
				$item_count ++;
			}
		}
	}
	$con=null;
	return $item_count.":".$total_weight;
}


?>