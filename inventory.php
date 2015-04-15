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
	 echo '<form method ="post">';
	 
	 if( !array_key_exists('s_product_id', $_POST) ) $product_id = ""; else $product_id = $_POST['s_product_id'];
						echo '<p>Work on inventory for all active products with names that begin with: ' ;
						echo '<input type="text" name="s_product_id" value="' . $product_id . '">';
	 echo('<input type="hidden" name="s_selected" value="1">');
	 echo '<p>When finished, hit <input type="submit" name="Update" value="Update"> to update the inventory with your changes.';
	 if( array_key_exists('s_selected', $_POST) ){					
		 $products = getproducts_beginningwith($product_id,"","active");
		 					
		 echo "<p><table><tr><td></td><td>Funding</td><td>Unit</td>".
		      "<td colspan=3>Last Inventory</td><td colspan=2 width=100>Shipments</td><td colspan=2 width=100>Receipts</td><td colspan=2>Current Stock</td></tr>";
		 echo "<tr><td width=150>Product</td><td>Source</td><td>Weight</td><td>Date</td><td>Case Lots</td><td>Wt</td>".
		      "<td>No</td><td>Total Wt</td><td>No</td><td>Total Wt</td>".
		      "<td>Case Lots</td><td>Weight</td></tr></table>";
		 echo '<div id="target" style="overflow: scroll; width: variable; height: 300px;">';
		 echo "<p><table>";
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
		 	echo "<td width=150>".$product->get_product_id() . "</td>".
		 		 "<td>".$product->get_funding_source(). "</td>".
		 		 "<td>".$product->get_unit_weight(). "</td>".
		 		 "<td width=20>".pretty_date($last_inventory[0]) ."</td><td width=20>".$last_inventory[1] ."</td><td width=40 align='right'>".$last_inventory[2] ."</td>".
		 		 "<td width=20 align='right'>".$ship_items[0] ."</td><td width=60 align='right'>".$ship_items[1] ."</td>".
		 		 "<td width=20 align='right'>".$receive_items[0]  ."</td><td width=60 align='right'>".$receive_items[1] ."</td>".
		 		 "<td>".'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type = "text" style="width:50px;" name="current_case_lots" value ="'.'">' ."</td>".
		 		 "<td>".'<input type = "text" style="width:50px;" name="current_weight" value ="'.$estimated_stock.'"></td>';
		    echo "</tr>";
		 }
		 echo '</table></div></form>';
	 }
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