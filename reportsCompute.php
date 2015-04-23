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

function report_shipments($fund_source, $from, $to) {
	include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    echo ("<br><b>Inventory Shipments Report</b><br></b> Report date: ".date("F d, Y")."<br>");
	echo "(This report may take a few seconds... please be patient.)<br>"; 
    if ($fund_source!="")
    	echo "<br>For funding source ".$fund_source;
    if ($from!="") {
        echo "<br>For shipments sent from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo "<br>For shipments sent before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<br><br><table><tr><td width='200px'><b>Product</b></td><td width='90px'><b>Total Wt.</b></td><td><b>Ship Date</b></td><td width='200px'><b>Customer</b></td><td><b>Weight</b></td></tr></table>";
    $items = retrieve_shipments($fund_source,$from,$to);
    if (count($items)>0) {			            
        echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<table>";
	    $item = array("","","","");
	    $total_wt = "";
	    $display_block = pretty_date($item[1])."</td><td>".$item[2]."</td><td>".$item[3]."</td></tr>";
	    foreach ($items as $item_next) {
	        $item_next = explode(":",$item_next);
	        if ($item_next[0] == $item[0]) {
	            $display_block.="<tr><td></td><td></td><td>".pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $total_wt += $item_next[3];
	        }
	        else {
	        	if ($item[0]!="")
	                echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	            $total_wt = $item_next[3];
	            $display_block = pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $item = $item_next;
	        }
	    }
	    echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	    echo "</table></div>";
    }
    else echo "There were no shipments in the given date range.";
}

function report_receipts($fund_source, $from, $to) {
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    echo ("<br><b>Inventory Receipts Report<br></b> Report date: ".date("F d, Y")."<br>");
    echo "(This report may take a few seconds... please be patient.)<br>"; 
    if ($fund_source!="")
    	echo "<br>For funding source ".$fund_source;
    if ($from!="") {
        echo "<br>For contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo "<br>For contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<br><br><table><tr><td width='200px'><b>Product</b></td><td width='90px'><b>Total Wt.</b></td><td><b>Rec. Date</b></td><td width='200px'><b>Provider</b></td><td><b>Weight</b></td></tr></table>";
    $items = retrieve_receipts($fund_source,$from,$to);
    if (count($items)>0) {			            
        echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<table>";
	    $item = array("","","","");
	    $total_wt = "";
	    $display_block = pretty_date($item[1])."</td><td>".$item[2]."</td><td>".$item[3]."</td></tr>";
	    foreach ($items as $item_next) {
	        $item_next = explode(":",$item_next);
	        if ($item_next[0] == $item[0]) {
	            $display_block.="<tr><td></td><td></td><td>".pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $total_wt += $item_next[3];
	        }
	        else {
	            if ($item[0]!="")
	                echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	            $total_wt = $item_next[3];
	            $display_block = pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
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
    echo ("<br><b>Inventory Report</b><br></b> Report date: ".date("F d, Y")."<br>");
    echo "(This report may take a few seconds... please be patient.)<br>"; 
    if ($funding_source!="")
    	echo "<br>For funding source ".$funding_source;
    if ($from!="") {
        echo "<br>For inventory beginning closest to ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo "<br>For inventory as of ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
   	echo "<p><table><tr><td></td><td width=40>Funding</td><td width=90>Status</td>".
		      "<td colspan=2 width=80>Last Inventory</td><td colspan=2 width=80>Shipments</td><td colspan=2 width=80>Receipts</td><td>Current Stock</td></tr>";
    echo "<tr><td width=140>Product</td><td>Source</td><td></td><td width=80>Date</td><td>Weight</td>".
		      "<td width=30>No</td><td>Total Wt</td><td width=30>No</td><td>Total Wt</td>".
		      "<td>Weight</td></tr></table>";
    $items = retrieve_inventory($status, $funding_source, $from, $to);
    echo '<br>'.count($items).' items were retrieved';		            
    if (count($items)>0) {			            
        echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<table>";
	    $item = array("","","","","","","","","","");
	    //$display_block = "<tr><td align=right><b>Product</b></td><td><b>Funding Source</b></td><td><b>Status</b></td><td><b>Most Recent History</b></td><td><b>Most Recent Weight</b></td><td><b>Shipped Cases</b></td><td><b>Shipped Weight</b></td><td><b>Received Cases</b></td><td><b>Received Weight</b></td><td><b>Current Weight</b></td></tr>";
	    $display_block = "";
	    foreach ($items as $item_next) {
	        $item_next = explode(":",$item_next);
	        $display_block.="<tr><td width=160>".$item_next[0]."</td><td width=40>".$item_next[1]."</td><td width=90>".$item_next[2].
	            "</td><td colspan=2 width=85>".pretty_date($item_next[3])."</td><td width=30>".$item_next[4]."</td><td width=30>".$item_next[5].
	            "</td><td width=50>".$item_next[6]."</td><td width=30>".$item_next[7]."</td><td width=50>".$item_next[8]."</td><td>".$item_next[9].
	            "</td><td>".$item_next[10]."</td></tr>"; 
	    }
	    echo $display_block;
	    echo "</table></div>";
    }
    else echo "There were no inventory histories in the given date range.";
}
function report_customers($status) {
	include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
    echo ("<br><b>Customers Report</b><br></b> Report date: ".date("F d, Y")."<br>");
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
	if($yy_mm_dd != "N/A")
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	else return $yy_mm_dd;
}
?>