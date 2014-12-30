<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Volunteer class for Homerestore
 * @author Allen Tucker
 * @version February 4, 2012
 */

class Volunteer {
	private $id; 	// id (unique key) = first_name . phone1
	private $last_name; 	// last name as a string
	private $first_name; 	// first name as a string
	private $address; 		// local address - string
	private $city; 	     	// city - string
	private $state; 		// state - string
	private $zip; 			// zip code - integer
	private $phone1; 		// primary phone (may be a cell)
	private $phone2; 		// alternate phone (may be a cell)
    private $email; 		// email address as a string
	private $type;   		// array of "driver", "floater", ÒwarehouseÓ, ÒpricerÓ, "register", "manager"
    private $status;   		// "applicant", "active", "on-leave", or "former"
 	private $license_no;  		// drivers license no.
	private $license_state;	  	// state of issue
	private $license_expdate; 	// expiration date yy-mm-dd
	private $availability; 	// array of day:week pairs; e.g. ÒMon:1Ó, ÒThu:4Ó
	private $birthday;     	// format: yy-mm-dd
	private $start_date;   	// format: yy-mm-dd (for applicants, date submitted)
	private $notes;			// misc notes about this volunteer
	private $password;     	// password for system access

        /**
         * constructor for a Volunteer
         */
    function __construct($last_name, $first_name, $address, $city, $state, $zip, $phone1, $phone2, $email, $type,
                         $status, $license_no, $license_state, $license_expdate, $availability, 
                         $birthday, $start_date, $notes, $password){                
        $this->id = $first_name . $phone1; 
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->phone1 = $phone1;
        $this->phone2 = $phone2;
        $this->email = $email;
        if ($type == "") 
        	$this->type = array();
        else 
        	$this->type = explode(',',$type);
        $this->status = $status;    
        $this->license_no = $license_no;
        $this->license_state = $license_state;
             
        if ($availability == "") 
        	$this->availability = array();
        else 
        	$this->availability = explode(',',$availability);
        $this->birthday = $birthday;
        $this->start_date = $start_date;
        $this->notes = $notes;   
        if ($password=="")
            $this->password = md5($this->id);
        else $this->password = $password;       
    }
    //getter functions
    function get_id() {
        return $this->id;
    }
    function get_first_name() {
        return $this->first_name;
    }
    function get_last_name() {
        return $this->last_name;
    }
    function get_address() {
        return $this->address;
    }
    function get_city() {
        return $this->city;
    }
    function get_state() {
        return $this->state;
    }
    function get_zip() {
        return $this->zip;
    }
    function get_phone1() {
        return $this->phone1;
    }
    function get_phone2() {
        return $this->phone2;
    }
    function get_email(){
        return $this->email;
    }
    function get_type(){
        return $this->type;
    }
    function get_status() {
        return $this->status;
    }
    function get_license_no() {
        return $this->license_no;
    }
    function get_license_state() {
        return $this->license_state;
    }
    function get_license_expdate() {
        return $this->license_expdate;
    }
    function get_availability() {
        return $this->availability;
    }
    function get_birthday(){
        return $this->birthday;
    }
    function get_start_date(){
    	return $this->start_date;
    }
	function get_notes(){
    	return $this->notes;
    }
	function get_password () {
        return $this->password;
    }
	function get_nice_phone1 () {
    	if (strlen($this->phone1)==10)
    		return substr($this->phone1,0,3)."-".substr($this->phone1,3,3)."-".substr($this->phone1,6);
    	else if (strlen($this->phone1)==7)
    		return substr($this->phone1,0,3)."-".substr($this->phone1,3);
    	else return $this->phone1;
    }
	//returns true if the person has type $t
    function is_type($t){
        if (in_array($t, $this->type))
            return true;
        else
            return false;
    }
	//returns true if the person is available on a particular day and week of the month
    function is_available($day, $week){
        if (in_array($day.":".$week, $this->availability))
            return true;
        else
            return false;
    }
    //setter functions ... can be added later as needed
    function set_license_expdate ($exp_date) {
        $this->license_expdate = $exp_date;
    }
    function set_birthday ($birthday) {
        $this->birthday = $birthday;
    }
    function set_password ($new_password) {
        $this->password = $new_password;
    }
        
}
?>
