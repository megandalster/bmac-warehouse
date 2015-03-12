<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
	
if (isset($_POST['_form_submit']) && $_POST['_form_submit'] == 'report') {
	show_report();
}

function show_report() {

	$status = $_POST['status'];
	$funding_source = $_POST['funding_source'];
	$from = $_POST["from"];
	$to   = $_POST["to"];	

	if (isset($_POST['report-types'])) {
		if (in_array('shipments', $_POST['report-types'])) {
			report_shipments($status, $funding_source, $from, $to);
		} 
		if (in_array('receipts', $_POST['report-types'])) {
			report_receipts($status, $funding_source, $from, $to);
		}
		if (in_array('inventory', $_POST['report-types'])) {
			report_inventory($status, $funding_source, $from, $to);
		}
	    if (in_array('customers', $_POST['report-types'])) {
	 		report_customers($status);
		}
		if (in_array('providers', $_POST['report-types'])) {
			report_providers($status);
		}
	}

}

function report_shipments($status, $funding_source, $from, $to) {
	include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    echo ("<br><b>Shipments Report</b>");
	// 1.  define a function in dbShipments to get all shipments with the given status, funding source, begin and end dates.	
	// 2.  call that function
	// 3.  display a table of the results, in order by date (earliest first)
}

function report_receipts($status, $funding_source, $from, $to) {
	include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    echo ("<br><b>Receipts Report</b>");
	// 1.  define a function in dbContributions to get all receipts with the given status, funding source, begin and end dates.	
	// 2.  call that function
	// 3.  display a table of the results, in order by date (earliest first)
}

function report_inventory($status, $funding_source, $from, $to) {
	include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 
    echo ("<br><b>Inventory Report</b>");
	// 1.  define a function in dbProducts to get all products with the given status, funding source, begin and end dates.	
	// 2.  call that function
	// 3.  display a table of the results, in order by product_id
}
function report_customers($status) {
	include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    echo ("<br><b>Customers Report</b>");
	// 1.  define a function in dbCustomers to get all customers with the given status.	
	// 2.  call that function
	// 3.  display a table of the results, in order by customer_id
}
function report_providers($status) {
	include_once('database/dbProviders.php');
    include_once('domain/Provider.php'); 
    echo ("<br><b>Providers Report</b>");
	// 1.  define a function in dbProviders to get all providers with the given status
	// 2.  call that function
	// 3.  display a table of the results, in order by provider_id
}
?>