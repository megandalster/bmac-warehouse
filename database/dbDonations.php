<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen 
 * Tucker.  This program is part of Homerestore, which is free software.  It comes 
 * with absolutely no warranty.  You can redistribute and/or modify it under the 
 * terms of the GNU Public License as published by the Free Software Foundation 
 * (see <http://www.gnu.org/licenses/).
*/

/**
 * dbDonations module for Homerestore
 * @author Nicholas Wetzel, Jim Garvey, and Sawyer Bowman
 * @version Oct 2013
 */

/*
 * This module implements all functionality with the 'Donation' database using mySQL queries. 
 */

include_once(dirname(__FILE__).'/../domain/Donation.php');
include_once(dirname(__FILE__).'/dbinfo.php');

// Create the DB donations table with the necessary column values.
function create_dbDonations() {
    connect();
    mysql_query("DROP TABLE IF EXISTS dbDonations");
    $result = mysql_query("CREATE TABLE dbDonations (id TEXT NOT NULL, area TEXT NOT NULL, date TEXT, donor_id TEXT NOT NULL, items TEXT, item_count TEXT, notes TEXT)");
    mysql_close();
    if (!$result) {
        echo mysql_error() . "Error creating dbDonations table. <br>";
        return false;
    }
    return true;
}

// Insert a donation and all of its values into the DB.
function insert_dbDonations ($donation){
    if (! $donation instanceof Donation) {
        return false;
    }
    connect();
	$query = "SELECT * FROM dbDonations WHERE id = '" . $donation->get_id() . "'";
    $result = mysql_query($query);
    if (mysql_num_rows($result) != 0) {
        delete_dbDonations ($donation->get_id());
        connect();
    }
    $query = "INSERT INTO dbDonations VALUES ('".
                $donation->get_id()."','" .
                $donation->get_area()."','".
                $donation->get_date()."','" .
                $donation->get_donor_id()."','" .
                implode(',',$donation->get_items())."','".
                $donation->get_item_count()."','".
                $donation->get_notes()."');";
    $result = mysql_query($query);
    if (!$result) {
        echo (mysql_error(). " unable to insert into dbDonations: " . $donation->get_id(). "\n");
        mysql_close();
        return false;
    }
    mysql_close();
    return true;
}

// Retrieve a donation from the DB by passing the donation ID.
function retrieve_dbDonations ($id) {
	connect();
    $query = "SELECT * FROM dbDonations WHERE id = '".$id."'";
    $result = mysql_query ($query);
    if (mysql_num_rows($result) !== 1){
    	mysql_close();
        return false;
    }
    $result_row = mysql_fetch_assoc($result);
    $theDonation = new Donation($result_row['id'], $result_row['area'], $result_row['date'], $result_row['donor_id'], $result_row['items'], $result_row['notes']);
	mysql_close(); 
    return $theDonation;   
}


function getall_dbDonations_between_dates ($donor_id, $start_date, $end_date) {
	connect();
	if($donor_id != ""){
		$query = "SELECT * FROM dbDonations WHERE ".
			     "donor_id LIKE '" . $donor_id . "' AND ".
			     "date BETWEEN '". $start_date ."' AND '". $end_date."'";
	}
	else{
		$query = "SELECT * FROM dbDonations WHERE ".
			     "date BETWEEN '". $start_date ."' AND '". $end_date."'";
	}
    $result = mysql_query ($query);
    $theDonations = array();
    while ($result_row = mysql_fetch_assoc($result)) {
    	$theDonation = new Donation($result_row['id'], $result_row['area'], $result_row['date'], $result_row['donor_id'], $result_row['items'], $result_row['notes']);
        $theDonations[] = $theDonation;
    }
	mysql_close();
    return $theDonations; 
}

// Update the values of a specified donation by removing it from the DB and then
// inserting it again. If it's not there, this acts like an insert
function update_dbDonations ($donation) {
	if (! $donation instanceof Donation) {
		echo ("Invalid argument for update_dbDonations function call");
		return false;
	}
	if (delete_dbDonations($donation->get_id()))
	   return insert_dbDonations($donation);
	else {
	   return insert_dbDonations($donation);
	}
}

// Remove a donation and all of its values from the DB.
function delete_dbDonations($id) {
	connect();
    $query="DELETE FROM dbDonations WHERE id=\"".$id."\"";
	$result=mysql_query($query);
	mysql_close();
	if (!$result) {
		echo (mysql_error()." unable to delete from dbDonations: ".$id);
		return false;
	}
    return true;
}