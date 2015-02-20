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
 * 
 * Contribution class for BMAC warehouse
 * @author Luis Munguia
 * @version February 4, 2015
 */
class Contribution {      
	private $provider_id;   // id of person/organization contributing
	private $receive_date;  // date and time recorded yy-mm-dd:hh:mm
	private $receive_items; // array of product_id:units:weight triples
	private $payment_source;// TEFAP, EFAP, EFAP-FB, CSFP, United Way, Donation
	private $billed_amt;    // amount of money billed, if any
	private $notes;		  // notes about this contribution	
	/**
	 *Constructor for Contribution
	 */
	function __construct($id, $receive_date, $receive_items, $payment_source, $billed_amt, $notes){                
        $this->provider_id = $id;
        $this->receive_date = $receive_date;
        $this->receive_items = array();
		if ($receive_items!="")
			$this->receive_items = explode(',',$receive_items);
		$this->payment_source = $payment_source; 
		$this->billed_amt = $billed_amt;     
        $this->notes = $notes;   
    }
    //getter functions
    function get_provider_id() { 
        return $this->provider_id;
    }
    function get_receive_date() {
    	return $this->receive_date;
    }
    function get_receive_items() {
    	return $this->receive_items;
    }
    function get_payment_source() {
    	return $this->notes;
    }
    function get_billed_amt() {
    	return $this->billed_amt;
    }
    function get_notes() {
    	return $this->notes;
    }

        
}
?>