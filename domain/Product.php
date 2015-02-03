<?php
class Product {
	private $product_id;	   // product name E.g., 'Beverages: Apple Juice�
	private $product_code;    // a unique code that identifies the product
	private $funding_source;  // �CSFP�, �TEFAP�, �EFAP�, or �donation�
	private $unit_weight;     // pounds / unit (case lot)  E.g.,   41
	private $unit_price; 	  // price per pound	       E.g.,    0.08
	private $initial_date;    // date and time first recorded yy-mm-dd:hh:mm
	private $initial_stock;   // initial number of units   E.g., 1000
	private $minimum_stock;   // replenish point (units)   E.g.,  100
	private $history;         // array of yy-mm:units:weight triples showing
					   // inventory level at the end of each month 
	private $current_stock;   // units:weight on hand
	private $inventory_date;  // yy-mm when last inventory was checked.
	private $status;	         // �active�, �discontinued�
    private $notes;	         //  notes about this product
}