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

function create_dbShipments(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbShipments");
	$result = mysql_query("CREATE TABLE dbShipments (customer_id TEXT NOT NULL, funds_source TEXT, 
							ship_date TEXT, ship_via TEXT, ship_items TEXT, ship_rate TEXT, 
							total_weight TEXT, total_price TEXT, invoice_date TEXT, invoice_no TEXT, 
							notes TEXT)");
	mysql_close();
	if(!$result){
		echo (mysql_error()."Error creating database dbShipments. \n");
		return false;
	}
	return true;
}

function retrieve_dbShipments($customer_id){
	connect();
	$result=mysql_query("SELECT * FROM dbShipments WHERE customer_id  = '".$customer_id."'");
	if(mysql_num_rows($result) !== 1){
		mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
							$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);
	mysql_close();
	return $theShipment;
	
}

function retrieve_dbShipmentsDate($ship_date){
	connect();
	$result=mysql_query("SELECT * FROM dbShipments WHERE ship_date  = '".$ship_date."'");
	if(mysql_num_rows($result) !== 1){
		mysql_close();
		return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
							$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);
	mysql_close();
	return $theShipment;
	
}


function getall_dbShipments(){
	connect();
	$result = mysql_query("SELECT * FROM dbShipments ORDER BY funds_source");
	$theVols = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theVol = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);	
		$theVols[] = $theVol;
	}
	mysql_close();
	return $theVols;
}


function getonlythose_dbShipments($customer_id, $ship_date1, $ship_date2, $ship_items) {
	connect();
	$query = "SELECT * FROM dbShipments WHERE customer_id LIKE '%".$customer_id."%'";
	if($ship_date1) 
		$query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2) 
		$query.= " AND ship_date <= '".$ship_date2.":23:59"."'"; 
	$query .= " AND ship_items LIKE '%".$ship_items."%'" ;
	$query .= " ORDER BY ship_date DESC";
	$result = mysql_query($query);
	$theShipments = array();

	while($result_row = mysql_fetch_assoc($result)){
		$theShipment = new Shipment($result_row['customer_id'], $result_row['funds_source'], $result_row['ship_date'], $result_row['ship_via'], $result_row['ship_items'], $result_row['ship_rate'],
		$result_row['total_weight'], $result_row['total_price'], $result_row['invoice_date'], $result_row['invoice_no'], $result_row['notes']);	
		$theShipments[] = $theShipment;
	}
	mysql_close();
	return $theShipments;
}

// retrieve shipments that match criteria and sort by customer_id and date
function retrieve_shipments($funds_source, $ship_date1, $ship_date2) { 
	connect();
	$query = "SELECT * FROM dbShipments WHERE funds_source LIKE '%".$funds_source."%'";
	if($ship_date1) $query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2) $query.=	" AND ship_date <= '".$ship_date2.":23:59"."'"; 
	$result = mysql_query($query);
	$thequads = array();
    $count = 0;	
	while(($result_row = mysql_fetch_assoc($result)) /*&& $count<100*/){
		$items = explode(",",$result_row['ship_items']);
		foreach ($items as $item) {
			$it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
			$thequad = $it[0].":".substr($result_row['ship_date'],0,8).":".$result_row['customer_id'].":".$it[2];
			$thequads[] = $thequad;
		}
	    $count++;
	}
	mysql_close();
	sort($thequads);
	return $thequads;
}

function insert_dbShipments($Shipment){
	if(! $Shipment instanceof Shipment){
		return false;
	}
	connect();
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
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbShipments: " . $Shipment->get_customer_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;

}

function update_dbShipments($Shipment){
	if (! $Shipment instanceof Shipment) {
		echo ("Invalid argument for update_dbShipment function call");
		return false;
	}
	if (delete_dbShipments($Shipment->get_customer_id()))
	return insert_dbShipments($Shipment);
	else {
		echo (mysql_error()."unable to update dbShipments table: ".$Shipment->get_customer_id());
		return false;
	}
}

function delete_dbShipments($customer_id){
	connect();
	$result = mysql_query("DELETE FROM dbShipments WHERE customer_id =\"".$customer_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbShipments: ".$customer_id);
		return false;
	}
	return true;
}

function delete_dbShipmentsDate($ship_date){
	connect();
	$result = mysql_query("DELETE FROM dbShipments WHERE ship_date =\"".$ship_date."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbShipments: ".$ship_date);
		return false;
	}
	return true;
}

// count shipments for a given product and payment source within the date range
// return the pair "no_shipments:total_wt" as a character string
function count_shipments($product_id, $payment_source, $ship_date1, $ship_date2) { 
	connect();
	$query = "SELECT * FROM dbShipments WHERE funds_source LIKE '%".$payment_source."%'";
  	if($ship_date1) $query.= " AND ship_date >= '".$ship_date1.":00:00"."'";
	if($ship_date2) $query.=	" AND ship_date <= '".$ship_date2.":23:59"."'"; 
	$result = mysql_query($query);
	$total_weight = 0;
	$item_count = 0;
	while(($result_row = mysql_fetch_assoc($result))){
		$items = explode(",",$result_row['ship_items']);
		foreach ($items as $item) {
			$it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
			if ($it[0]!=$product_id) 
			    continue;
			$total_weight += $it[2];
			$item_count ++;
		}
	}
	mysql_close();
	return $item_count.":".$total_weight;
}


?>