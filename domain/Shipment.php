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
 * Shipment class for BMAC-Warehouse.
 * @author Dylan Martin
 * @version February 6, 2014
 */

class Shipment {
    private $customer_id;	  // id of customer receiving the shipment
	private $funds_source;  // id of funds source for this shipment
	private $ship_date;     // date and time recorded yy-mm-dd:hh:mm
    private $ship_via;       // �BMAC�, �Customer�, �Other�
    private $ship_items;     // array of product_id:units:weight triples
	private $ship_rate;      // rate per pound for this shipment
    private $total_weight;	    //  total weight shipped
	private $total_price;	    //  total price this shipment 
    private $invoice_date;    //  date of invoice yy-mm-dd 
	private $invoice_no;      // invoice number -- not used
    private $notes;           // notes about this shipment
    
       /**
         * constructor for a Shipment
         */
    function __construct($customer_id, $funds_source, $ship_date, $ship_via, $ship_items, $ship_rate, $total_weight, 
    					$total_price, $invoice_date, $invoice_no, $notes){      
    	$this->customer_id = $customer_id;
		$this->funds_source = $funds_source;
		$this->ship_date = $ship_date;
		$this->ship_via = $ship_via;
		$this->ship_items = array();
		if ($ship_items!="")
			$this->ship_items = explode(',',$ship_items);
		$this->ship_rate = $ship_rate;
		$this->total_weight = $total_weight;
		$this->total_price = $total_price;
		$this->invoice_date = $invoice_date;
		$this->invoice_no = $invoice_no;
		$this->notes = $notes;
    }
    //getter functions
    function get_customer_id() {
    	return $this->customer_id;
    }
    function get_funds_source() {
    	return $this->funds_source;
    }
    function get_ship_date() {
    	return $this->ship_date;
    }
    function get_ship_via() {
    	return $this->ship_via;
    }
	function get_ship_items() {
		return $this->ship_items;
	}
	function set_ship_items($si) {
		$this->ship_items = $si;
	}
	function get_ship_rate() {
		return $this->ship_rate;
	}
	function get_total_weight() {
		return $this->total_weight;
	}
	function set_total_weight($wt) {
		$this->total_weight = $wt;
	}
	function get_total_price() {
		return $this->total_price;
	}
	function get_invoice_date() {
		return $this->invoice_date;
	}
	function get_invoice_no() {
		return $this->invoice_no;
	}
	function get_notes() {
		return $this->notes;
	}
}