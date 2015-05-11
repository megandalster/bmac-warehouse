<?php

//Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
//David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is
//free software.  It comes with absolutely no warranty. You can redistribute and/or
//modify it under the terms of the GNU General Public License as published by the
//Free Software Foundation (see <http://www.gnu.org/licenses/ for more information)

// Customer class for BMAC-Warehouse.
// @author Moustafa ElBadry
// @version February 3, 2015 

class Customer {
        private $customer_id;   // uniquely identifies customer  e.g. "Campfire"
        private $code;			// a unique code that identifies the customer
        private $address;       // street/shipping address 
        private $city;          // city
        private $state;         // 2-letter abbrev - usually WA
        private $zip;           // zip code 
        private $county;        // county
        private $contact;       // contact name
        private $phone;         // contact phone 
        private $email;         // contact email
        private $status;        // active, inactive
        private $notes;         // notes about this customer
  
    // constructor for a Customer
        function __construct($customer_id, $code, $address, $city, $state, $zip, $county, $contact, $phone, $email, $status, $notes) {
            $this->customer_id = $customer_id;
            $this->code = $code;
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
       function get_customer_id() {
          return $this->customer_id;
         }
       function get_code() {
       	  return $this->code;
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
?>
