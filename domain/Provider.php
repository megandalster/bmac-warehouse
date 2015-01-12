<?php
class Provider {
	private $provider_id;  // name of provider e.g. �FEMA� or "Second Harvest"
	private $type;		    // �funds� or �food�
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
}