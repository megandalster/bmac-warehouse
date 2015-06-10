<?PHP
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
/**
 *	shipmentInvoice.php
 *  displays a shipping label or invoice for printing
 *	@author Allen Tucker
 *	@version April 30, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
	date_default_timezone_set('America/Los_Angeles');
	$id = $_GET["id"];  // expecting "yy-mm-dd:hh:mm"
	$shipment = retrieve_dbShipmentsDate($id);
	$customer = retrieve_dbCustomers($shipment->get_customer_id());
?>
<html>
	<head>
		<title>
			Editing <?PHP echo('Displaying Shipping Label or Invoice '.$shipment->get_ship_date());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
<body>
  <div id="container">
	<div id="shipinvoiceheader"></div>
	<div id="shippinginvoicecontent">
	<b><br>Invoice No: 
	<?php 
	echo $shipment->get_ship_date();
	echo "<br>Ship Date: ".pretty_date(substr($shipment->get_ship_date(),0,8));
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Ship Via: </td><td>".$shipment->get_ship_via();
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Funds Source: </td><td>".$shipment->get_funds_source();
	echo "<br><br>Ship To: <br>&nbsp;&nbsp;&nbsp;&nbsp;".$customer->get_customer_id();
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;".$customer->get_address().", ".$customer->get_city().", ".
				$customer->get_state()."  ".$customer->get_zip();
	?>
	<br><br><fieldset>
<legend>Items shipped</legend>
<table><tr><td>Product </td>
<td>Unit Wt</td>
<td>Case Lots</td>
<td>Total Wt. </td></tr>
		
<?php
	$itemArray = $shipment->get_ship_items();
	$total1 = 0; $total2=0;
	foreach ($itemArray as $item) {
		echo "<tr>";
		$details = explode(":",$item);
		if (strpos($details[0],";")>0) {
			$unit_weight = substr($details[0],strrpos($details[0],";")+1);
			$details[0] = substr($details[0],0,strpos($details[0],";"));
			if ($details[2]=="" && $details[1]!="")
				$details[2] = $unit_weight*$details[1];
		} 
		else $unit_weight = "";
		echo "<td>".$details[0] . '</td>';
		echo "<td align=right>".$unit_weight.'</td>';
	    echo "<td align=right>". $details[1] .'</td>';
		echo "<td align=right>".$details[2] . '</td>';
		$total1 += $details[1];
		$total2 += $details[2];
		echo "</tr>";
	}
    echo '<tr><td></td><td>Totals:</td><td align=right>'.
	    $total1.'</td><td align=right>',$total2.'</td><td>pounds.</tr></table>';
    echo '</fieldset>';
    
    echo '<p>Rate: '. $shipment->get_ship_rate() . '';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;Billed Amt: '. $shipment->get_total_price() . '';	
    echo('<p>Notes: '.$shipment->get_notes());
    echo('<br><br><br><p>BMAC Signature __________________________________________ ');
    echo('<p>Agency Signature __________________________________________');
?>	
	
	
	
	</div>	
	
	<?php 
	function pretty_date($yy_mm_dd) {
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	}
	?>
  </div>
</body>
</html>