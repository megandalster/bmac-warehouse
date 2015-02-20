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
 * 
 * Contributions database for BMAC warehouse
 * @author Luis Munguia
 * @version February 13, 2015
 */


include_once(dirname(__FILE__).'/../domain/Contribution.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbContributions(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbContributions");
	$result = mysql_query("CREATE TABLE dbContributions (provider_id TEXT NOT NULL, receive_date TEXT, 
	                       receive_items TEXT, payment_source TEXT, billed_amt TEXT, notes TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database dbContributions. \n");
			return false;
	}
	return true;
}
function retrieve_dbContributions($provider_id){
	connect();
	$result=mysql_query("SELECT * FROM dbContributions WHERE provider_id = '".$provider_id."'");
	if(mysql_num_rows($result)!== 1){
		mysql_close();
		return false;
		}
		$result_row = mysql_fetch_assoc($result);
		$theCon = new Contribution($result_row['provider_id'], $result_row['receive_date'], $result_row['receive_items'], 
		                           $result_row['payment_source'], $result_row['billed_amt'], $result_row['notes']);
		mysql_close();
		return $theCon;
}


function getall_dbContributions(){
	connect();
	$result = mysql_query("SELECT * FROM dbContributions ORDER BY provider_id");
	$theCons = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theCon = new Contribution($result_row['provider_id'], $result_row['receive_date'], $result_row['receive_items'], 
		                           $result_row['payment_source'], $result_row['billed_amt'], $result_row['notes']);
		$theCons[] = $theCon;
	}
	mysql_close();
	return $theCons;
}


// retrieve only those Contributions that match the criteria given in the arguments
function getonlythose_dbContributions($provider_id, $receive_date1, $receive_date2, $receive_items) { 
	connect();
	$query = "SELECT * FROM dbContributions WHERE provider_id LIKE '%".$provider_id."%'" . 
			 " AND receive_date > '%".$receive_date1."%'" .
			 " AND receive_date < '%".$receive_date2."%'" . 
			 "  AND receive_items LIKE '%".$receive_items."%'" ;
    $query .= " ORDER BY provider_id";
	$result = mysql_query($query);
	$theCons = array();
		
	while($result_row = mysql_fetch_assoc($result)){
		$theCon = new Contribution($result_row['provider_id'], $result_row['receive_date'], $result_row['receive_items'], 
		                           $result_row['payment_source'], $result_row['billed_amt'], $result_row['notes']);
		$theCons[] = $theCon;
	}
	mysql_close();
	return $theCons;
}

function insert_dbContributions($Contribution){
	if(! $Contribution instanceof Contribution){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbContributions WHERE provider_id = '" . $Contribution->get_provider_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbContributions ($Contribution->get_provider_id());
		connect();
	}
	$query = "INSERT INTO dbContributions VALUES ('".
				$Contribution->get_provider_id()."','" .
				$Contribution->get_receive_date()."','".
				implode(',',$Contribution->get_receive_items())."','".
				$Contribution->get_payment_source()."','".
				$Contribution->get_billed_amt()."','".
				$Contribution->get_notes().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbContributions: " . $Contribution->get_provider_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbContributions($Contribution){
	if (! $Contribution instanceof Contribution) {
		echo ("Invalid argument for update_dbContributions function call");
		return false;
	}
	if (delete_dbContributions($Contribution->get_provider_id()))
	return insert_dbContributions($Contribution);
	else {
		echo (mysql_error()."unable to update dbContributions table: ".$Contribution->get_provider_id());
		return false;
	}
}


function delete_dbContributions($provider_id){
	connect();
	$result = mysql_query("DELETE FROM dbContributions WHERE provider_id =\"".$provider_id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbContributions: ".$provider_id);
		return false;
	}
	return true;
}
?>