<?php
class Contribution {      
	private $provider_id;   // id of person/organization contributing
	private $receive_date;  // date and time received yy-mm-dd:hh:mm
	private $receive_items; // array of product_id:units:weight triples
	private $notes;		  // notes about this contribution	
}