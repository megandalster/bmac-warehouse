<?php
class Shipment {
    private $customer_id;	  // id of customer receiving the shipment
	private $funds_source;  // id of funds source for this shipment
	private $ship_date;     // date and time recorded yy-mm-dd:hh:mm
    private $ship_via;       // ÒBMACÓ, ÒCustomerÓ, ÒOtherÓ
    private $ship_items;     // array of product_id:units:weight triples
	private $ship_rate;      // rate per pound for this shipment
    private $total_weight;	    //  total weight shipped
	private $total_price;	    //  total price this shipment 
    private $invoice_date;    //  date of invoice yy-mm-dd 
	private $invoice_no;      // invoice number
    private $notes;           // notes about this shipment
}