<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Donor class for Homerestore
 * @author Hartley Brody, Nick Wetzel & Sawyer Bowman
 * @version October 8, 2013
 */
class Donor {
	private $id;     		// uniquely identifies the donor
	private $month_name;	// mm
	private $day_name;		// dd
	private $year_name;		// yy
	private $type;			// individual or organization
	private $address;       // street address � string
	private $city;			// city
	private $state;			// 2-letter abbrev - usually SC
	private $zip; 	      	// zip code 
	private $neighborhood;	// plantation or neighborhood, eg "Sun City"
	private $phone1;		// primary phone 
	private $email;			// email of contact person
    private $notes; 		// notes written by the team captain or coordinator
    private $lat;          // geo coordinates for mapping
    private $lng;
	
	
	// constructor method
	function __construct($id, $month_name, $day_name, $year_name, $type, $address, $city, $state, $zip,
	                     $neighborhood, $phone1, $email, $notes){
		                
        $this->id       	= $id; 
        $this->month_name	= $month_name;
       	$this->day_name		= $day_name; 
       	$this->year_name	= $year_name;             
        $this->type 		= $type;      
        $this->address 		= $address;      
        $this->city 		= $city;      
        $this->state 		= $state;      
        $this->zip 			= $zip;
        $this->neighborhood = $neighborhood;
        $this->phone1 		= $phone1;
        $this->email		= $email;
        $this->notes 		= $notes;
        $this->lat = 0.0;
 		$this->lng = 0.0;
    }
    //getter functions
    function get_id() {
        return $this->id;
    }
    function get_month(){
    	return $this->month_name;
    }
    function get_day(){
        return $this->day_name;
    }
    function get_year(){
    	return $this->year_name;
    }
    function get_type() {
        return $this->type;
    }
    function get_address() {
        return $this->address;
    }
    function get_mapAddress() {
        return str_replace(' ','+',$this->address.", ".$this->city.", ".$this->state);
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
    function get_neighborhood(){
    	return $this->neighborhood;
    }
    function get_phone1() {
        return $this->phone1;
    }
    function get_email() {
    	return $this->email;
    }
    function get_notes(){
        return $this->notes;
    }
	function get_lat(){
    	return $this->lat;
    }
    function get_lng(){
    	return $this->lng;
    }
    function get_nice_phone1 () {
    	if (strlen($this->phone1)==10)
    		return substr($this->phone1,0,3)."-".substr($this->phone1,3,3)."-".substr($this->phone1,6);
    	else if (strlen($this->phone1)==7)
    		return substr($this->phone1,0,3)."-".substr($this->phone1,3);
    	else return $this->phone1;
    }
    //setter functions ... can be added later as needed
        
}
?>