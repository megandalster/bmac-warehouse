<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * Donation class for Homerestore
 * @author Nicholas Wetzel, Allen Tucker & Sawyer Bowman
 * @version October 12, 2013
 */

/*
 * This class serves as the basis for all actions associated with the a donation.
 * A donation can be constructed and edited with the functions provided by this class.
 */

class Donation {
	private $id;		// String $yy-mm-ddhh:mm:ss (using date and time recorded)
	private $area;	    // String area (truck1, truck2, or decon)
	private $date; 	    // date of pick-up
	private $donor_id; 
	private $items;		// array of item counts for this donation
	private $item_count; // total item count for this donation
	private $notes;		// notes for/from the driver 
	
	// Constructor for an indvidual Donation/Client
	function __construct($id, $area, $date, $donor_id, $items, $notes){
		$this->id = $id ;
		$this->area = $area;
		$this->date = $date;
		$this->donor_id = $donor_id;
		$this->items = explode(',',$items);  	
        $this->set_all_totals();
		$this->notes = $notes;
	}
	
	//Getter functions for the donation
	function get_id(){
		return $this->id;
	}
	function get_id() {
		return $this->id;
	}
	function get_date() {
		return $this->date;
	}
	// return id in readable form
	function get_pretty_id() {
		$i = $this->id;
		$datetime = mktime(substr($i,8,2),substr($i,11,2),substr($i,14,2),
						substr($i,3,2),substr($i,6,2),substr($i,0,2));
		return date("l M j, Y, g:i:sa",$datetime);
	}
	// return date and area in readable form
	function get_pretty_date() {
		$i = $this->date;
		$date = mktime(0,0,0,substr($i,3,2),substr($i,6,2),substr($i,0,2));
		return date("l M j, Y",$date);
	}	
	function get_area(){
		return $this->area;
	}
	function get_donor_id(){
		return $this->donor_id;
	}
	function get_items(){
		return $this->items;
	}
	// Returns the count of donation type based on the numeric index parameter.
	function get_count($index){
		$item_counts = array();
		foreach($this->items as $item){
        	$item_counts[] = $item;
		}
        return $item_counts[$index];
	}
	function get_notes(){
		return $this->notes;
	}
	function get_item_count() {
		return $this->item_count;
	}
	function get_date() {
		return $this->date;
	}
	
	// Setter functions for the Donation class.
	
	// Sets the total count by accessing and summing the counts
	// of each donation type in the donation's item array.
	function set_all_totals(){
		$this->item_count = 0;
		foreach($this->items as $item){
			$this->item_count += $item; 		
		}
	}
	
	function set_date($date){
		$this->date = $date;
	}
	function set_area($area){
		$this->area = $area;
	}
	function set_item_count($count){
		$this->item_count = $count;
	}
	function set_id($new_id){
		$this->id = $new_id;
	}
	function set_donor_id($new_donor_id){
		$this->donor_id = $new_donor_id;
	}
	// Adds an item to the end of the donation's array of items.
	function add_item ($new_item) {
        $this->items[] = $new_item;
        $this->set_all_totals();    
    }
    // Sets the specified item to the specified index into the item array
    // if not there, add it.
    function set_item($index, $new_item){
        $this->items[$index] = $new_item;
        $this->set_all_totals();
    }
    // items is an array of type:count pairs
    function set_item_counts($items){
		$this->items = $items;
		$this->set_all_totals();
	}
	function set_notes($new_notes){
		$this->notes = $new_notes;
	}
	function remove_all_items(){
		$this->items = array();
		$this->set_all_totals();
	}
	function remove_item ($item_type) {
		for ($i=0; $i<sizeof($this->items);$i++) {
			if (strpos($this->items[$i],$item_type)==0) {
			    array_splice($this->items,$i,1);
			    break;
			}
		}
		$this->set_all_totals();	
	}
}
?>