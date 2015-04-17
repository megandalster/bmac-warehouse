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
			report_providers($status, $from, $to);
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
    echo ("<br><b>Warehouse Receipts Report<br></b> Report date: ".date("F d, Y")."<br>");
    if ($fund_source!="")
    	echo "<br>For funding source ".$fund_source;
    if ($from!="") {
        echo "<br>For contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo "<br>For contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<br><br><table><tr><td width='170px'><b>Product</b></td><td><b>Total Wt.</b></td><td><b>Rec. Date</b></td><td width='200px'><b>Provider</b></td><td><b>Weight</b></td></tr></table>";
    $items = retrieve_receipts($fund_source,$from,$to);
    if (count($items)>0) {			            
        echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<table>";
	    $item = array("","","","");
	    $total_wt = "";
	    $display_block = $item[1]."</td><td>".$item[2]."</td><td>".$item[3]."</td></tr>";
	    foreach ($items as $item_next) {
	        $item_next = explode(":",$item_next);
	        if ($item_next[0] == $item[0]) {
	            $display_block.="<tr><td></td><td></td><td>".$item_next[1]."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $total_wt += $item_next[3];
	        }
	        else {
	            echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	            $total_wt = $item_next[3];
	            $display_block = $item_next[1]."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $item = $item_next;
	        }
	    }
	    echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	    echo "</table></div>";
    }
    else echo "There were no contributions in the given date range.";
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
	include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
    echo ("<br><b>Customers Report</b>");
	// 1.  define a function in dbCustomers to get all customers with the given status.	
	//     The function is written in dbCustomers with the name "getonlythosestatus_dbCustomers($status)"
	// 2.  call that function
	$resultcustomers =  getonlythosestatus_dbCustomers($status);
	// 3.  display a table of the results, in order by customer_id
    if ($status!="") echo ' with status like "'.$status.'"'; 
    
    if (sizeof($resultcustomers)>0) {
							
							echo '<p><table> <tr><td><strong>Name</strong></td><td><strong>Phone</strong></td><td><strong>Contact Person</strong></td><td><strong>Address</strong></td><td><strong>City</strong></td><td><strong>State</strong></td><td><strong>Zip Code</strong></td></tr>';
                            $allEmails = array(); // for printing all emails
                            foreach ($resultcustomers as $customer) {
								echo "<tr><td><a href=customerEdit.php?id=".urlencode($customer->get_customer_id()).">" .
								    $customer->get_customer_id() . "</a></td><td>" .
									$customer->get_phone() . "</td><td>" . 
									$customer->get_contact() . "</td><td>" .
									$customer->get_address() . "</td><td>" .
									$customer->get_city() . "</td><td>" .
									$customer->get_state() . "</td><td>" .
									$customer->get_zip() . "</td><td>" ;	
									
									
								echo "</td></a></tr>";
                            }
							echo '</table>';  
}
}

function report_providers($status, $from, $to) {
	include_once('database/dbProviders.php');
    include_once('domain/Provider.php'); 
    
    echo ("<br><b>Providers Report<br></b> Report date: ".date("F d, Y")."<br>");
	if ($status != "")
    	echo "<br>For ".$status." providers";
    else {
    	echo "<br>For all providers";
    }
    if ($from!="") {
        echo " with contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") {
    	echo " with contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    }
    
    $data = getcontributionsby_dbProviders($status, $from, $to);
    
    echo("<br><br>");
    echo('<div id="target" style="overflow: scroll; width: variable; height: 400px">');
    echo("<table>");
    echo("<tr><td><b>Provider</b></td>
              <td><b>Date Received</b></td>
              <td><b>Billed Amount</b></td>
              <td><b>Total Weight</b></td></tr>");
    foreach($data as $entry) {
    	$provider = $entry["provider"];
    	$contributions = $entry["contributions"];
    	$total_billed_amt = 0;
    	$total_weight = 0;
    	
    	$first = true;
    	foreach($contributions as $contr) {
    		if($first) {
    			echo("<tr><td>".$provider->get_provider_id()."</td>");
    			$first = false;
    		} else {
    			echo("<tr><td></td>");
    		}
    		
    		$total_billed_amt += floatval($contr->get_billed_amt());
    		$total_weight     += floatval($contr->get_total_weight());
    		
    		echo("<td>".pretty_date($contr->get_receive_date())
    	   ."</td><td>$".$contr->get_billed_amt()
    	   ."</td><td>".$contr->get_total_weight()." lbs.</td>");
    	}
    	if(count($contributions) > 1) {
	    	echo('<tr><td></td><td></td>
	    	          <td style="border-top: 2px solid #000000">$'.$total_billed_amt.'</td>
	    	          <td style="border-top: 2px solid #000000">'.$total_weight.' lbs.</td></tr>');
    	}
    	echo("<tr><td></td><td></td><td></td><td></td></tr>");
    	echo("<tr><td></td><td></td><td></td><td></td></tr>");
    	echo("<tr><td></td><td></td><td></td><td></td></tr>");
    }
    
    echo("</table>");
    echo("</div>");
}
function pretty_date($yy_mm_dd) {
	return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
}
?>