<?php
class Customer {
	private $customer_id;   // uniquely identifies customer  e.g. "Campfire"
	private $address;       // street/shipping address 
	private $city;			// city
	private $state;			// 2-letter abbrev - usually WA
	private $zip; 	      	// zip code 
	private $county;			// county
	private $contact;		// contact name
	private $phone;			// contact phone 
	private $email;			// contact email
	private $status;		// active, inactive
	private $notes; 		// notes about this customer
}