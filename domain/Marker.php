<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Marker class for Homerestore
 * @author Allen Tucker
 * @version July 2014
 */
class Marker {
	private $id;     		// == the donor name (uniquely identifies the Marker)
	private $address;       // Google Map address
	private $lat;          // geo coordinates for mapping
    private $lng;
    private $type;			// Truck 1, Truck 2, or DECON
    private $neighborhood;	// // plantation or neighborhood, eg "Sun City"
    
	
	
	// constructor method
	function __construct($id, $address, $lat, $lng, $type, $neighborhood){
		                
        $this->id       	= $id; 
        $this->address 		= $address;       
        $this->lat = $lat;
 		$this->lng = $lng;
 		$this->type 		= $type;      
        $this->neighborhood = $neighborhood;
    }

    //getter functions
    function get_id() {
        return $this->id;
    }
    function get_address() {
        return $this->address;
    }
    function get_lat(){
    	return $this->lat;
    }
    function get_lng(){
    	return $this->lng;
    }
    function get_type() {
        return $this->type;
    }
    function get_neighborhood(){
    	return $this->neighborhood;
    }
        
}
?>