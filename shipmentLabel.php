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
 *  displays a shipping label and invoice for printing
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
			Editing <?PHP echo('Displaying Shipping Label and Invoice '.$shipment->get_ship_date());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
<body>
  <div id="container">
    <div id="shiplabelheader"></div>
	<div id="shippinglabelcontent">
	<table>
	<tr><td style="font-size:44px; font-family: times; font-style: italic;  color:#005190; font-weight:bold;" >Ship To:</td></tr>
	<tr><td></td><td style="font-size:44px; font-family: times; color:#005190; font-weight:normal;">
    <?php 	
	echo $customer->get_customer_id(); echo "<br>";
	echo $customer->get_address(); echo "<br>";
	echo $customer->get_city().", ".$customer->get_state()."  ". $customer->get_zip(); echo "<br>";
	; echo "<br>";
	?>
	</td></tr></table><table><tr><td>
	Invoice No: 
	</td><td>
	<?php 
	echo $shipment->get_ship_date();
	echo "</td><td></td><td></td><td>Funds Source:</td><td>".$shipment->get_funds_source();
	echo "</td></tr><tr><td>Ship Date: </td><td>".pretty_date(substr($shipment->get_ship_date(),0,8));
	echo "</td><td>Ship Via: </td><td>".$shipment->get_ship_via();
	echo "</td><td>Total Weight: </td><td>".$shipment->get_total_weight(). " lbs.";
	?>
	</td></tr></table>
	</div>	
	
	<?php 
	function pretty_date($yy_mm_dd) {
		return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
	}
	?>
  </div>
</body>
</html>