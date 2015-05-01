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
    <style type="text/css">
		h1 {padding-left: 0px; padding-right:165px; }
	</style>
	<div id="shiplabelheader"></div>
	<div id="shippinglabelcontent">
	shipping label goes here.
	</div>
	<br><br>
	<div id="shipinvoiceheader"></div>
	<div id="content">
	shipping invoice goes here.
	</div>	
  </div>
</body>
</html>