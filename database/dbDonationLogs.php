<?php
/*
 * Copyright 2014-2015 by Hartley Brody, Richardo Hopkins, Nicholas Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * @version September 25, 2013
 * @author Allen Tucker and Richardo Hopkins
 */

include_once(dirname(__FILE__).'/../domain/DonationLog.php');
include_once(dirname(__FILE__).'/dbDonations.php');
include_once(dirname(__FILE__).'/dbDonors.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function create_dbDonationLogs() {
	connect();
	mysql_query("DROP TABLE IF EXISTS dbDonationLogs");
	$result = mysql_query("CREATE TABLE dbDonationLogs(id TEXT NOT NULL, donations TEXT, status TEXT, notes TEXT)");
	mysql_close();
	if(!$result){
		echo (mysql_error()."Error creating database table dbDonationLogs. \n");
		return false;
	}
	return true;
}
/*
 * insert a new donationLog to dbDonationLogs table and its donations to the dbDonations table:
 * if already there, return false
 */
function insert_dbDonationLogs($donationLog){
        if(! $donationLog instanceof DonationLog) die("Error: insert_dbDonationLogs type mismatch");
        connect();
        $query = "SELECT * FROM dbDonationLogs WHERE id = '".$donationLog->get_id()."'";
        $result = mysql_query($query);
        //if there's no entry for this id, create it
        if ($result == null || mysql_num_rows($result) == 0) {
                mysql_query('INSERT INTO dbDonationLogs VALUES("'.
                $donationLog->get_id().'","'.
                implode(',', $donationLog->get_donations()).'","'.
                $donationLog->get_status().'","'.
                $donationLog->get_notes().
                     '");');
                mysql_close();
                return true;
        }
        mysql_close();
        return false;
}
/*
 * remove a donationLog from dbDonationLogs table but leave all its donations in the dbDonations table
 */
function delete_dbDonationLogs($donationLog) {
	connect();
	$query = 'SELECT * FROM dbDonationLogs WHERE id = "'. $donationLog->get_id() . '"';
	$result = mysql_query($query);
	if ($result==null || mysql_num_rows($result) == 0) {
		mysql_close();
		return false;
	}
	$query='DELETE FROM dbDonationLogs WHERE id = "'.$donationLog->get_id().'"';
	$result=mysql_query($query);
	mysql_close();
	return true;
}
/*
 * @return a single row from dbDonationLogs table matching a particular id.
 * if not in table, return false
 */
function get_donationLog($id){
	connect();
	$query = 'SELECT * FROM dbDonationLogs WHERE id = "'.$id.'"';
    $result = mysql_query($query);
    
	if ($result==null || mysql_num_rows($result) !== 1) {
		mysql_close();
		return false;
	}	
	$result_row = mysql_fetch_assoc($result);
	$theDonationLog = new DonationLog($result_row['id'],
			$result_row['donations'],
			$result_row['status'],
			$result_row['notes']);
	mysql_close();
	return $theDonationLog;
}

/*
 * @update a row by deleting it and then adding it again
 */
function update_dbDonationLogs($donationLog) {
	if (! $donationLog instanceof DonationLog)
	die ("Invalid argument for update_dbDonationLogs");
	if (delete_dbDonationLogs($donationLog))
		return insert_dbDonationLogs($donationLog);
	else return false;
}

?>
