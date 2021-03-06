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
	if ($_POST['export'])	
		$export = "yes";
	else $export = "no";
	date_default_timezone_set('America/Los_Angeles');
                	
	if (isset($_POST['report-types'])) {
		if (in_array('shipments', $_POST['report-types'])) {
			report_shipments($funding_source, $from, $to, $export);
		} 
		if (in_array('receipts', $_POST['report-types'])) {
			report_receipts($funding_source, $from, $to, $export);
		}
		if (in_array('inventory', $_POST['report-types'])) {
			report_inventory($status, $funding_source, $export);
		}
	    if (in_array('customers', $_POST['report-types'])) {
	 		report_customers2($status, $from, $to, $funding_source, $export);
		}
		if (in_array('providers', $_POST['report-types'])) {
			report_providers($status, $from, $to, $export);
		}
	}
}

function report_shipments($fund_source, $from, $to, $export) {
	include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    $heading = "";
    if ($fund_source!="")
    	$heading .= " for funding source ".$fund_source;
    if ($from!="") {
        $heading .=  " for shipments sent from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           $heading .= " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	$heading .= " for shipments sent before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<b>Inventory Shipments Report</b> ".$heading;
    echo ("<br>Report date: ".date("F d, Y")."<br>");
	$heading = "Inventory Shipments Report".$heading;
    
    echo "<br><table><tr><td width=180><b>Product</b></td><td><b>Total Wt.</b></td><td><b>Ship Date</b></td><td width=180><b>Customer</b></td><td><b>Weight</b></td></tr></table>";
    $cl1 = array("Product", "Ship Date", "Customer", "Weight");
    $cl2 = "";
    $items = retrieve_shipments($fund_source,$from,$to);
    if (count($items)>0) {
    	$data = array();			            
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
	        	if ($item[0]!="") {
	                echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	        	}
	            $total_wt = $item_next[3];
	            $display_block = pretty_date($item_next[1])."</td><td>".$item_next[2]."</td><td>".$item_next[3]."</td></tr>";
	            $item = $item_next;
	        }
	        $data[] = array($item_next[0],pretty_date($item_next[1]),$item_next[2],$item_next[3]);
	    }
	    echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	    echo "</table></div>";
	    if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $data);
    }
    else echo "There were no shipments in the given date range.";
}

function report_receipts($fund_source, $from, $to, $export) {
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    $heading = "";
    if ($fund_source!="")
    	$heading .= " for funding source ".$fund_source;
    if ($from!="") {
        $heading .=  " for contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           $heading .= " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	$heading .= " for contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<b>Inventory Receipts Report</b> ".$heading;
    echo ("<br>Report date: ".date("F d, Y")."<br>");
	$heading = "Inventory Receipts Report".$heading;
/*    
	echo ("<br><b>Inventory Receipts Report<br></b> Report date: ".date("F d, Y")."<br>");
    if ($fund_source!="")
    	echo "<br>For funding source ".$fund_source;
    if ($from!="") {
        echo "<br>For contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           echo " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	echo "<br>For contributions received before ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
*/    echo "<br><br><table><tr><td width='200px'><b>Product</b></td><td width='90px'><b>Total Wt.</b></td><td><b>Rec. Date</b></td><td width='200px'><b>Provider</b></td><td><b>Weight</b></td></tr></table>";
    $cl1 = array("Product", "Rec. Date", "Provider", "Weight");
    $cl2 = "";
    $items = retrieve_receipts($fund_source,$from,$to);
    if (count($items)>0) {			            
        $data = array();			            
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
	        $data[] = array($item_next[0],pretty_date($item_next[1]),$item_next[2],$item_next[3]);
	    }
	    echo "<tr><td>".$item[0]."</td><td>".$total_wt."</td><td>".$display_block;
	    echo "</table></div>";
	    if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $data);
    }
    else echo "There were no contributions in the given date range.";
}

function report_inventory($status, $funding_source, $export) {
	include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 
    
    if ($status=="inactive") $status = "discontinued";
    $items = retrieve_inventory($status, $funding_source);
    $heading = count($items)." ".$status." products";
    if ($funding_source!="")
   		$heading .=  " and funding source = ".$funding_source;
   	$heading .= ".";
   	echo "<br><b>Inventory Report</b> for ".$heading;
   	$heading = "Inventory Report for ".$heading;
   	echo ("<br></b> Report date: ".date("F d, Y")."<br>");
    if (count($items)>0) {	
    	$cl1 = array("","Funding","Last Inventory","","Shipments","","Receipts","","Current Stock");
    	echo "<table><tr><td></td><td><b>Funding</b></td>".
		      "<td colspan=2 width=100><b>Last Inventory</b></td><td colspan=2><b>Shipments</b></td><td colspan=2><b>Receipts</b></td><td><b>Current Stock</b></td></tr>";
    	$cl2 = array("Product","Source","Date","Weight","No","Total Wt","No","Total Wt","Weight");
    	echo "<tr><td width=160><b>Product</b></td><td width=60><b>Source</b></td><td width=90><b>Date</b></td><td width=50><b>Weight</b></td>".
		      "<td width=30><b>No</b></td><td width=60><b>Total Wt</b></td><td width=30><b>No</b></td><td width=80><b>Total Wt</b></td>".
		      "<td width=40><b>Weight</b></td></tr></table>";
    		            
        echo '<div id="target" style="overflow: scroll; width: variable; height: 400px">';
        echo "<table>";
	    $display_block = "";
	    $data = array();
	    foreach ($items as $item_next) {
	    	$item_next = explode(":",$item_next);
	        $d = array($item_next[0],$item_next[1],pretty_date($item_next[3]),$item_next[4],$item_next[5],$item_next[6],$item_next[7],$item_next[8],$item_next[9],$item_next[10]);
	        $data[] = $d;
	        $display_block.="<tr><td width=160>".$item_next[0]."</td><td width=60>".$item_next[1].
	            "</td><td width=90>".pretty_date($item_next[3])."</td><td width=50>".$item_next[4]."</td><td width=40>".$item_next[5].
	            "</td><td width=60>".$item_next[6]."</td><td width=60>".$item_next[7]."</td><td width=30>".$item_next[8]."</td><td width=80>".$item_next[9].
	            "</td><td width=40>".$item_next[10]."</td></tr>"; 
	    }
	    echo $display_block;
	    echo "</table></div>";
	    if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $data);
    }
    else echo "<br>There are no items with this status and funding source.";
}
function report_customers($status, $export) {
	include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
    $heading = "Customers Report ";
    if ($status!="") $heading .= "with status ".$status;  
    echo ("<br><b>".$heading."</b><br></b> Report date: ".date("F d, Y")."<br>");
    
	$resultcustomers =  getonlythosestatus_dbCustomers($status);  
    if (sizeof($resultcustomers)>0) {
		echo '<p><table> <tr><td><strong>Name</strong></td><td><strong>Phone</strong></td><td><strong>Contact</strong></td><td><strong>Address</strong></td><td><strong>City</strong></td><td><strong>State</strong></td><td><strong>Zip Code</strong></td></tr>';
        $cl1 = array("Name", "Phone", "Email", "Contact", "Address", "City", "State", "Zip");
        $cl2 = "";
        $data = array();
        foreach ($resultcustomers as $customer) {
			echo "<tr><td><a href=customerEdit.php?id=".urlencode($customer->get_customer_id()).">" .
				$customer->get_customer_id() . "</a></td><td>" .
				pretty_phone($customer->get_phone()) . "</td><td>" . 
				$customer->get_email() . "</td><td>" . 
				$customer->get_contact() . "</td><td>" .
				$customer->get_address() . "</td><td>" .
				$customer->get_city() . "</td><td>" .
				$customer->get_state() . "</td><td>" .
				$customer->get_zip() . "</td><td>" ;	
				echo "</td></a></tr>";
		$data[] = array($customer->get_customer_id(),pretty_phone($customer->get_phone()),$customer->get_email(),
		                $customer->get_contact(),$customer->get_address(),$customer->get_city(),
		                $customer->get_state(),$customer->get_zip());
        }
		echo '</table>';
		if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $data);
    }
}

function report_customers2($status, $from, $to, $funds_source, $export) {
	include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
    $heading = "";
    if ($from!="") {
        $heading .=  " for shipments sent from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           $heading .= " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	$heading .= " for shipments sent through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<b>Customers Report</b> ".$heading;
    echo ("<br>Report date: ".date("F d, Y")."<br>");
	$heading = "Customers Report".$heading;
    
    $data = getshipmentsby_dbCustomers($status, $from, $to, $funds_source);
	if (count($data)>0){
		$cl1 = array("Customer", "Date Shipped", "Funds Source", "Total Weight");
        $cl2 = "";
        $exportlines = array();
	
	    echo("<br><br>");
	    echo('<div id="target" style="overflow: scroll; width: variable; height: 400px">');
	    echo("<table>");
	    echo("<tr><td><b>Customer</b></td>
	              <td><b>Date Shipped</b></td>
	              <td><b>Funds Source</b></td>
	              <td><b>Total Weight</b></td></tr>");
	    foreach($data as $entry) {
	    	$customer = $entry["customer"];
	    	$shipments = $entry["shipments"];
	    	$total_weight = 0;
	    	
	    	$first = true;
	    	foreach($shipments as $contr) {
	    		if($first) {
	    			echo("<tr><td>".$customer->get_customer_id()."</td>");
	    			$first = false;
	    		} else {
	    			echo("<tr><td></td>");
	    		}
	    		
	    		$total_weight     += floatval($contr->get_total_weight());
	    		
	    		echo("<td>".pretty_date($contr->get_ship_date())
	    		."</td><td>".$contr->get_funds_source()."</td>"
	    	   ."</td><td>".$contr->get_total_weight()." lbs.</td>");
	    	   $csvline = array($customer->get_customer_id(), pretty_date($contr->get_ship_date()), 
	    	   		$contr->get_funds_source(), $contr->get_total_weight());
	    	   $exportlines[] = $csvline;
	    	   
	    	}
	    	if(count($shipments) > 1) {
		    	echo('<tr><td></td><td></td><td></td>
		    	          <td style="border-top: 2px solid #000000">'.$total_weight.' lbs.</td></tr>');
	    	}
	    	echo("<tr><td></td><td></td><td></td><td></td></tr>");
	    	echo("<tr><td></td><td></td><td></td><td></td></tr>");
	    }
	    echo("</table>");
	    echo("</div>");
	    if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $exportlines);
	} 
}

function report_providers($status, $from, $to, $export) {
	include_once('database/dbProviders.php');
    include_once('domain/Provider.php'); 
    
    $heading = "";
    if ($from!="") {
        $heading .=  " for contributions received from ".date("F d, Y",mktime(0,0,0,substr($from,3,2),substr($from,6,2),substr($from,0,2)));
        if ($to!= "")
           $heading .= " through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2))); 
    }
    else if ($to!="") 
    	$heading .= " for contributions received through ".date("F d, Y",mktime(0,0,0,substr($to,3,2),substr($to,6,2),substr($to,0,2)));
    echo "<b>Providers Report</b> ".$heading;
    echo ("<br>Report date: ".date("F d, Y")."<br>");
	$heading = "Providers Report".$heading;
    
    $data = getcontributionsby_dbProviders($status, $from, $to);
	if (count($data)>0){
		$cl1 = array("Provider", "Address", "Date Received", "Billed Amount", "Total Weight");
        $cl2 = "";
        $exportlines = array();
	
	    echo("<br><br>");
	    echo('<div id="target" style="overflow: scroll; width: variable; height: 400px">');
	    echo("<table>");
	    echo("<tr><td><b>Provider</b></td>
	              <td><b>Address</b></td>
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
	    			echo("<td>".$provider->get_address()." ".$provider->get_city()." ".$provider->get_state()." ".$provider->get_zip()."</td>");
	    			$first = false;
	    		} else {
	    			echo("<tr><td></td><td></td>");
	    		}
	    		
	    		$total_billed_amt += floatval($contr->get_billed_amt());
	    		$total_weight     += floatval($contr->get_total_weight());
	    		
	    		echo("<td>".pretty_date($contr->get_receive_date())
	    	   ."</td><td>$".$contr->get_billed_amt()
	    	   ."</td><td>".$contr->get_total_weight()." lbs.</td>");
	    	   $csvline = array($provider->get_provider_id(), 
	    	   		$provider->get_address()." ".$provider->get_city()." ".$provider->get_state()." ".$provider->get_zip(),
	    	   		pretty_date($contr->get_receive_date()), $contr->get_billed_amt(), $contr->get_total_weight());
	    	   $exportlines[] = $csvline;
	    	   
	    	}
	    	if(count($contributions) > 1) {
		    	echo('<tr><td></td><td></td><td></td>
		    	          <td style="border-top: 2px solid #000000">$'.$total_billed_amt.'</td>
		    	          <td style="border-top: 2px solid #000000">'.$total_weight.' lbs.</td></tr>');
	    	}
	    	echo("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
	    	echo("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
	    }
	    echo("</table>");
	    echo("</div>");
	    if ($export=="yes") 
		    export_report ($heading, $cl1, $cl2, $exportlines);
	} 
}
function pretty_date($yy_mm_dd) {
	if($yy_mm_dd != "N/A")
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	else return $yy_mm_dd;
}
function pretty_phone($p) {
	if(strlen($p)!=10)
		return $p;
	else return substr($p,0,3)."-".substr($p,3,3)."-".substr($p,6);
}

function export_report($heading, $col_labels, $col_labels2, $data) {
	$filename = "export.csv";
	$handle = fopen($filename, "w");
	fputcsv($handle, array($heading));
	fputcsv($handle, array("Report date: ".date("F d, Y")));
	fputcsv($handle, array());
	fputcsv($handle, $col_labels);
	if ($col_labels2!="")
		fputcsv($handle,$col_labels2);
	foreach ($data as $aline) {
		fputcsv($handle, $aline);
	}
	fclose($handle);
}

?>