<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * inventory worksheet for BMAC Warehouse
 * @author Luis Munguia
 * @version 3/13/2015
 */
	session_start();
	session_cache_expire(30);
	
include_once('database/dbContributions.php');
include_once('domain/Contribution.php');
include_once('database/dbShipments.php');
include_once('domain/Shipment.php'); 
include_once('database/dbProducts.php');
include_once('domain/Product.php'); 
?>
<html>
	<head>
		<title>
			BMAC-Warehouse Inventory script
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
		<script>
		$(function() {
			    $( "#target" ).scroll();
		});
		</script>
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
<?php
     echo "<p><b>Current Inventory Worksheet</b><br> Today's date: ".date('F d, Y')."<br><br>";
	 echo '<form method ="post"><div id="target" style="overflow: scroll; width: variable; height: 300px;">';
	 echo "<table><tr><td colspan=3> </td>".
	      "<td colspan=3>Last Inventory</td><td colspan=2>Shipments</td><td colspan=2>Receipts</td><td colspan=2>Current Stock</td></tr>";
	 echo "<tr><td>Product</td><td>Funds Source</td><td>Unit Wt</td><td>Date</td><td>Case Lots</td><td>Total Wt</td>".
	      "<td>Number</td><td>Total Wt</td><td>Number</td><td>Total Wt</td>".
	      "<td>Case Lots</td><td>Total Wt</td></tr>";
	 $products = getonlythose_dbProducts("","","active");
	 foreach ($products as $product){
	 	echo "<tr>";
	 	if (count($product->get_history())>0) 
	 		$last_inventory = explode(":",end($product->get_history()));  // the array [date,caselots,weight]
	 	else 
	 		$last_inventory = explode(":","::") ;
	 	$ship_items = explode(":",count_shipments($product->get_product_id(), $product->get_funding_source(),"",""));   // the array [number,weight]
	 	$receive_items = explode(":",count_receipts($product->get_product_id(), $product->get_funding_source(),"","")); // the array [number,weight]
	 	if ($last_inventory[0]=="")
	 		$estimated_stock = "";
	 	else $estimated_stock = $last_inventory[2] + $receive_items[1] - $ship_items[1];
	 	// display a line in the table
	 	echo "<td>".$product->get_product_id() . "</td>".
	 		 "<td>".$product->get_funding_source(). "</td>".
	 		 "<td>".$product->get_unit_weight(). "</td>".
	 		 "<td>".pretty_date($last_inventory[0]) ."</td><td>".$last_inventory[1] ."</td><td>".$last_inventory[2] ."</td>".
	 		 "<td>".$ship_items[0] ."</td><td>".$ship_items[1] ."</td>".
	 		 "<td>".$receive_items[0]  ."</td><td>".$receive_items[1] ."</td>".
	 		 "<td>".'<input type = "text" name="current_case_lots" value ="'.'">' ."</td>".
	 		 "<td>".'<input type = "text" name="current_weight" value ="'.$estimated_stock.'"></td>';
	    echo "</tr>";
	 }
	 echo '</table></div></form>';
	 
	 function pretty_date($d) {
	 	if ($d=="")
	 	    return "";
	 	return date('m/d/y',mktime(0,0,0,substr($d,3,2),substr($d,6,2),substr($d,0,2)));
	 }
 	?>	
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>