<?php
/*
 * Copyright 2014 by Hartley Brody, Richardo Hopkins, Nicholas Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * dbMarkers module for Homerestore
 * @author Allen Tucker
 * @version August 2014
 */

include_once(dirname(__FILE__).'/../domain/Donor.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbMarkers(){
	connect();
	mysql_query("DROP TABLE IF EXISTS dbMarkers");
	$result = mysql_query("CREATE TABLE dbMarkers (id TEXT NOT NULL, address TEXT NOT NULL, 
							lat FLOAT(10,6) NOT NULL, lng FLOAT(10,6) NOT NULL,
                            type TEXT, neighborhood TEXT)");
	mysql_close();
	if(!$result){
			echo (mysql_error()."Error creating database table dbMarkers. <br>");
			return false;
	}
	return true;
}

function retrieve_dbMarkers($id){
	connect();
	$result = mysql_query("SELECT * FROM dbMarkers WHERE id  = '".$id."'");
	if(mysql_num_rows($result) != 1){
			mysql_close();
			return false;
	}
	$result_row = mysql_fetch_assoc($result);
	$theMarker = new Marker($result_row['id'], $result_row['address'], $result_row['lat'], $result_row['lng'], 
					$result_row['type'], $result_row['neighborhood']);
	mysql_close();
	return $theMarker;
}


function getall_dbMarkers(){
	connect();
	$result = mysql_query("SELECT * FROM dbMarkers ORDER BY id");
	$theMarkers = array();
	while($result_row = mysql_fetch_assoc($result)){
		$theMarker = new Marker($result_row['id'], 
				$result_row['address'], 
				$result_row['lat'], 
				$result_row['lng'], 
				$result_row['type'], 
				$result_row['neighborhood']);
		$theMarkers[] = $theMarker;
	}
	mysql_close();
	return $theMarkers;
}

function insert_dbMarkers($marker){
	if(!$marker instanceof Marker){
		return false;
	}
	connect();
	$query = "SELECT * FROM dbMarkers WHERE id = '" . $marker->get_id() . "'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		delete_dbMarkers($marker->get_id());
		connect();
	}
	$query = "INSERT INTO dbMarkers VALUES ('".
				$marker->get_id()."','" .
				$marker->get_address()."','".
				$marker->get_lat()."','".
				$marker->get_lng()."','".
				$marker->get_type()."','".
				$marker->get_neighborhood().
	            "');";
	$result = mysql_query($query);
	if (!$result) {
		echo (mysql_error(). " Unable to insert into dbMarkers: " . $marker->get_id(). "\n");
		mysql_close();
		return false;
	}
	mysql_close();
	return true;
	
}

function update_dbMarkers($marker){
	if (! $marker instanceof Marker) {
		echo ("Invalid argument for update_dbMarkers function call");
		return false;
	}
	if (delete_dbMarkers($marker->get_id()))
	return insert_dbMarkers($marker);
	else {
		echo (mysql_error()."unable to update dbMarkers table: ".$marker->get_id());
		return false;
	}
}

function delete_dbMarkers($id){
	connect();
	$result = mysql_query("DELETE FROM dbMarkers WHERE id =\"".$id."\"");
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbMarkers: ".$id);
		return false;
	}
	return true;
}
?>