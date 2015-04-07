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
	$funding_source = $_POST['funding-source'];
	$from = $_POST["from"];
	$to   = $_POST["to"];	

	if (isset($_POST['report-types'])) {
		if (in_array('shipments', $_POST['report-types'])) {
			report_shipments($funding_source, $from, $to);
		} 
		if (in_array('receipts', $_POST['report-types'])) {
			report_receipts($funding_source, $from, $to);
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

function report_receipts($fund_source, $from, $to) {
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    echo ("<br><b>Warehouse Receipts Report<br></b> Report date: ".date("F d, Y")."<br><br>");
    $items = retrieve_receipts($fund_source,$from,$to,"");
    echo ' '.count($items).' items were retrieved';		            
    if ($fund_source!="")
    	echo ", for funding source ".$fund_source;
    if ($from!="") {
        echo ", for contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo ", for contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    if (count($items)>0) {
    	echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<br><table><tr><td><b>Product</b></td><td align=right><b>Total Wt.</b></td><td align=right width=100><b>Rec. Date</b></td><td><b>Provider</b></td><td align=right><b>Weight</b></td></tr>";
	    $item = array("","","","");
	    $total_wt = "";
	    $display_block = $item[1]."</td><td>".$item[2]."</td><td>".$item[3]."</td></tr>";
	    foreach ($items as $item_next) {
	        $item_next = explode(":",$item_next);
	        if ($item_next[0] == $item[0]) {
	            $display_block.="<tr><td></td><td></td><td align=right>".pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td align=right>".$item_next[3]."</td></tr>";
	            $total_wt += $item_next[3];
	        }
	        else {
	            echo "<tr><td>".$item[0]."</td><td align=right>".$total_wt."</td><td align=right>".$display_block;
	            $total_wt = $item_next[3];
	            $display_block = pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td align=right>".$item_next[3]."</td></tr>";
	            $item = $item_next;
	        }
	    }
	    echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	    echo "</table></div>";
    }
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
function pretty_date($yy_mm_dd) {
	return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
}
?>