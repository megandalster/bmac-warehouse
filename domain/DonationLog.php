<?php 
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * DonationLog class for Homerestore 
 * @author Richardo Hopkins, Allen Tucker & Sawyer Bowman
 * @version September 25, 2012
 */
class DonationLog {
	private $id;			// String: "yy-mm-dd" serves as a unique id 
	private $donations;		// array of donation id's 
    private $status;		// "created", "published", or "completed"
    private $notes;			

		/**
         * constructor for a DonationLog
         */
    function __construct($id, $donations, $status, $notes){
        $this->id = $id;  	
    	if ($donations == "")
    		$this->donations = array();
    	else $this->donations = explode(',', $donations);
    	if ($status == "") 
    		$this->status = "created";
    	else $this->status = $status;	
    	$this->notes = $notes;
    }
    
    // getter functions
    function get_id() {
    	return $this->id;
    }
    function get_donations() {
    	return $this->donations;
    }
    function get_num_donations() {
    	return count($this->donations);
    }
    function get_status() {
    	return $this->status;
    }
    function get_day() {
    	$timestamp = mktime(0,0,0,substr($this->id,3,2),substr($this->id,6,2),substr($this->id,0,2)); 	
    	return date('l F j, Y', $timestamp);
    }
    function get_notes() {
    	return $this->notes;
    }
    // setter functions
    function change_status($new_status) {
    	$this->status = $new_status;
    }
    function remove_donation($donationID){
    	$size = count($this->donations);
    	for ($i=0; $i < $size; $i++){
    		if (!strcmp($this->donations[$i], $donationID)){
    			array_splice($this->donations, $i, 1);
    			break;
    		}
    	}
    }
    function add_donation($donationID){
    	if (!in_array($donationID, $this->donations))  // avoid duplicates
    		$this->donations[]= $donationID;
    }
    function set_status($status){
     	$this->status = $status;
    }
    function set_notes($notes) {
    	$this->notes = $notes;
    }
    function set_donations($donations) {
    	$this->donations = $donations;
    }
}
?>