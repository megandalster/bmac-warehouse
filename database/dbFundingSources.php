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
 * Functions to create, update, and retrieve information from the
 * dbFundingSourcess table in the database.
 * @version May 1, 2015
 * @author Allen Tucker
 */

include_once(dirname(__FILE__).'/dbinfo.php');
/**
 * adds a new funding source and codes
 */
function add_funding_source($id, $al){
	$con=connect();
	$query = "INSERT INTO dbFundingSources (id, code) VALUES (\"".$id."\",\"".$al."\")";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not add to dbFundingSources ".$p->getMessage());
	}
	if (!$result) {
	    echo ("Unable to add funding source \n");
	    $con=null;
	    return false;
	}
	$con=null;
	return true;
}

function get_funding_source($id){
	$con=connect();
	$query = "select * dbFundingSources where id=\"".$id."\"";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbFundingSources ".$p->getMessage());
	}
	if (!$result) {
	    echo ("Unable to retrieve funding source: " .$id. "\n");
	    $con=null;
	    return false;
	}
	$log = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$log[$result_row['id']]=$result_row['code'];
	}
	return $log;
}

/**
 * deletes a funding source
 */
function delete_funding_source($id){
	$con=connect();
	$query="DELETE FROM dbFundingSources WHERE id=\"".$id."\"";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not delete from dbFundingSources ".$p->getMessage());
	}
	if(!$result) {
	    echo ("Unable to delete funding source: ".$id);
	    return false;
	}
    return true;
}

/**
 * returns an associative array of id => code pairs
 */
function get_all_funding_sources(){
	$con=connect();
	$query="SELECT * FROM dbFundingSources order by id";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbFundingSources ".$p->getMessage());
	}
	$con=null;
	if(!$result) {
		die("error getting funding sources");
	}
	$log = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$log[$result_row['id']]=$result_row['code'];
	}
	return $log;
}

function get_all_codes(){
	$con=connect();
	$query="SELECT * FROM dbFundingSources order by id";
	try {
	    $result = $con->query($query);
	} catch (PDOException $p) {
	    die("Could not retrieve from dbFundingSources ".$p->getMessage());
	}
	$con=null;
	if(!$result) {
		die("error retrieving funding sources");
	}
	$log = array();
	while($result_row = $result->fetch(PDO::FETCH_ASSOC)){
		$log[$result_row['code']]=$result_row['id'];
	}
	return $log;
}

?>
