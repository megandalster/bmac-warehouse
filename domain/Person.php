<?php
/*
 * Copyright 2013 by ... and Allen Tucker. 
 * This program is part of BMAC-Warehouse, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */


/**
 * Person class for BMAC-Warehouse.
 * @author Allen Tucker
 * @version Decembber 29, 2014
 */
include_once(dirname(__FILE__).'/../database/dbPersons.php');

class Person {
    private $id;    // id (unique key) = first_name . phone1
    private $first_name; // first name as a string
    private $last_name;  // last name as a string
    private $address;   // address - string
    private $city;    // city - string
    private $state;   // state - string
    private $zip;    // zip code - integer
    private $phone1;   // main phone
    private $phone2;   // alternate phone
    private $email;   // email address as a string
    private $type;       // "manager", "office", or "warehouse", 
    private $status;     // "applicant", "active", "on-leave", or "former"
    private $notes;        // notes that only the manager can see and edit
    private $password;     // password for calendar and database access: default = $id

        /**
         * constructor for a Volunteer
         */
    function __construct($last_name, $first_name, $address, $city, $state, $zip, $phone1, $phone2, $email, $type,
                         $status, $notes, $password){                
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
        $this->type = $type;
        $this->status = $status;    
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
        return $this->type == $t;
    }
    function set_password ($new_password) {
        $this->password = $new_password;
    }
        
}
?>
        