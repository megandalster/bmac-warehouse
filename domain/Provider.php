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
 * Provider class for BMAC-Warehouse.
 * @author David Quennoz
 * @version January 30, 2015
 */
class Provider {
	private $provider_id;   // name of provider e.g. ÒFEMAÓ or "Second Harvest"
	private $code;			// unique code identifying the provider
	private $type;		    // ÒfundsÓ or ÒfoodÓ
	private $address;       // street address 
	private $city;			// city
	private $state;			// 2-letter abbrev - usually WA
	private $zip; 	      	// zip code 
	private $county;		// county
	private $contact;		// contact name
	private $phone;			// contact phone 
	private $email;			// contact email
	private $status;		// active, inactive
	private $notes; 		// notes about this supplier
	
		 /**
         * constructor for a Provider
         */
    function __construct($provider_id, $code, $type, $address, $city, $state, $zip, $county, $contact, $phone, $email,
                         $status, $notes){                
		$this->provider_id = $provider_id;
		$this->code = $code;
		$this->type = $type;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->county = $county;
		$this->contact = $contact;
		$this->phone = $phone;
		$this->email = $email;
		$this->status = $status;
		$this->notes = $notes;
    }
    //getter functions
    function get_provider_id() {
    	return $this->provider_id;
    }
    function get_code() {
    	return $this->code;
    }
    function get_type() {
    	return $this->type;
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
	function get_county() {
		return $this->county;
	}
	function get_contact() {
		return $this->contact;
	}
	function get_phone() {
		return $this->phone;
	}
	function get_nice_phone() {
    	if (strlen($this->phone)==10)
    		return substr($this->phone,0,3)."-".substr($this->phone,3,3)."-".substr($this->phone,6);
    	else if (strlen($this->phone)==7)
    		return substr($this->phone,0,3)."-".substr($this->phone,3);
    	else return $this->phone;
	}
	function get_email() {
		return $this->email;
	}
	function get_status() {
		return $this->status;
	}
	function get_notes() {
		return $this->notes;
	}
}