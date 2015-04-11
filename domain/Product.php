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
 * @author Noah Jensen
 * @version February 4, 2015
 */

class Product {
	private $product_id;	   // product name E.g., 'Beverages: Apple JuiceÕ
	private $product_code;    // a unique code that identifies the product
	private $funding_source;  // ÒCSFPÓ, ÒTEFAPÓ, ÒEFAPÓ, or ÒdonationÓ
	private $unit_weight;     // pounds / unit (case lot)  E.g.,   41
	private $unit_price; 	   // price per pound	         E.g.,    0.08
	private $initial_date;   // date first in warehouse yy-mm-dd
	private $initial_stock;   // initial number of units   E.g., 1000
	private $minimum_stock;   // replenish point (units)   E.g.,  100
	private $history;         // array of yy-mm-dd:units:weight triples showing
					          // physical inventory -- sorted by date (most recent last)
	private $current_stock;   // units:weight on hand
	private $inventory_date;  // yy-mm when last inventory was checked.
	private $status;	         // ÒactiveÓ, ÒdiscontinuedÓ
    private $notes;	         //  notes about this product


 /**
         * constructor for a Product
         */
    function __construct($product_id, $product_code, $funding_source, $unit_weight, $unit_price, $initial_date, $initial_stock, $minimum_stock, $history, $current_stock,
                         $inventory_date, $status, $notes){                
        $this->product_id = $product_id; 
        $this->product_code = $product_code;
        $this->funding_source = $funding_source;
        $this->unit_weight = $unit_weight;
        $this->unit_price = $unit_price;
        $this->initial_date = $initial_date;
        $this->initial_stock = $initial_stock;
        $this->minimum_stock = $minimum_stock;
        $this->history = array();
		if ($history!="")
			$this->history = explode(',',$history);
        $this->current_stock = $current_stock;
        $this->inventory_date = $inventory_date;
        $this->status = $status;    
        $this->notes = $notes;   
     
    }
    //getter functions
    function get_product_id() {
        return $this->product_id;
    }
    function get_product_code() {
        return $this->product_code;
    }
    function get_funding_source() {
        return $this->funding_source;
    }
    function get_unit_weight() {
        return $this->unit_weight;
    }
    function get_unit_price() {
        return $this->unit_price;
    }
    function get_initial_date() {
        return $this->initial_date;
    }
    function get_initial_stock() {
        return $this->initial_stock;
    }
    function get_minimum_stock() {
        return $this->minimum_stock;
    }
    function get_history() {
        return $this->history;
    }
    function get_current_stock(){
        return $this->current_stock;
    }
    function get_inventory_date(){
        return $this->inventory_date;
    }
    function get_status() {
        return $this->status;
    }
    function get_notes(){
    	return $this->notes;
    }

    function is_funding_source($s){
        return $this->funding_source == $s;
    }
    
    // add to the product's history the next inventory reading 'yy-mm-dd:units:weight'
    function add_to_history($yymmddunitsweight) {
        $this->history[] = $yymmddunitsweight;
    }
    
}
?>
    
    