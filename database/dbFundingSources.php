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
  * Sets up a new dbFundingSources table by dropping and recreating
  * id - name of the funding source
  * code - the old database code for each one

function create_dbFundingSources(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbFundingSources");
	$result=mysql_query("CREATE TABLE dbFundingSources (id TEXT, code TEXT)");
	mysql_close();
	if(!$result) {
		echo mysql_error();
		return false;
	}
	return true;
}
*/
/**
 * adds a new funding source and codes
 */
function add_funding_source($id, $al){
	$time=time();
	connect();
	$query = "INSERT INTO dbFundingSources (id, code) VALUES (\"".$id."\",\"".$al."\")";
	$result=mysql_query($query);
	if(!$result){
		echo mysql_error();
		return false;
	}
	mysql_close();
	return true;
}

function get_funding_source($id){
	$time=time();
	connect();
	$query = "select * dbFundingSources where id=\"".$id."\"";
	$result=mysql_query($query);
	if(!$result){
		echo mysql_error();
		return false;
	}
	$log = array();
	for($i=0;$i<mysql_num_rows($result);++$i) {
		$result_row=mysql_fetch_assoc($result);
		$log[$result_row['id']]=$result_row['code'];
	}
	return $log;
}

/**
 * deletes a funding source
 */
function delete_funding_source($id){
	connect();
	$query="DELETE FROM dbFundingSources WHERE id=\"".$id."\"";
	$result=mysql_query($query);
	if(!$result) {
		echo mysql_error();
		return false;
	}
    return true;
}

/**
 * returns an associative array of id => code pairs
 */
function get_all_funding_sources(){
	connect();
	$query="SELECT * FROM dbFundingSources order by id";
	$result=mysql_query($query);
	mysql_close();
	if(!$result) {
		die("error getting funding sources");
	}
	else{
		$log = array();
		for($i=0;$i<mysql_num_rows($result);++$i) {
			$result_row=mysql_fetch_assoc($result);
			$log[$result_row['id']]=$result_row['code'];
		}
	}
	return $log;
}

function get_all_codes(){
	connect();
	$query="SELECT * FROM dbFundingSources order by id";
	$result=mysql_query($query);
	mysql_close();
	if(!$result) {
		die("error getting funding sources");
	}
	else{
		$log = array();
		for($i=0;$i<mysql_num_rows($result);++$i) {
			$result_row=mysql_fetch_assoc($result);
			$log[$result_row['code']]=$result_row['id'];
		}
	}
	return $log;
}

?>
