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
include_once('database/dbContributions.php');
include_once('domain/Contribution.php');
include_once('database/dbShipments.php');
include_once('domain/Shipment.php'); 
include_once('database/dbProducts.php');
include_once('domain/Product.php'); 
     echo ("Current Inventory Worksheet<br> Worksheet date: ".date('F d, Y')."<br><br>");
	 echo "<table><tr><td colspan=3> </td>".
	      "<td colspan=3>Last Inventory</td><td colspan=2>Shipments</td><td colspan=2>Receipts</td><td colspan=2>Current Stock</td></tr>";
	 echo "<tr><td>Product</td><td>Funds Source</td><td>Unit Wt</td><td>Date</td><td>Case Lots</td><td>Total Wt</td>".
	      "<td>Number</td><td>Total Wt</td<td>Number</td><td>Total Wt</td>>".
	      "<td>Case Lots</td><td>Total Wt</td></tr>";
	 $products = getall_dbProducts();
	 echo '<form method ="post"><div id="target" style = flow: scroll; width: variable; height: 300px;">';
	 foreach ($products as $product){
	 	if ($product->get_history()) 
	 		$last_inventory = end($product->get_history);
	 	else 
	 		$last_inventory = "::" ;
	 	$ship_items = count_shipments($product->get_id(), $product->get_funding_source());
	 	$receive_items = count_receipts($product->get_id(), $product->get_funding_source());
	 	$initial_stock = reset($product_get_history());
	 	if ($last_inventory=="::"){
	 		$initial_stock_array = explode(":",$initial_stock);
	 		$receive_items_array = explode(":",$receive_items);
	 		$ship_items_array = explode(":",$ship_items);
	 		$estimated_stock = $initial_stock_array[1] + $receive_items_array[1] - $ship_items_array[1].":"."WEIGHT";
	 	}
	 	else $current_stock = $last_inventory;
	 	// display a line in the table
	 	echo "<br>".$product->get_id() .
	 		 $product ->get_funding_source().
	 		 $product->get_unit_weight .
	 		 $last_inventory .
	 		 $ship_items .
	 		 $receive_items  .
	 		 '<input type = "text" name="current_case_lots" value ="'.'">' .
	 		 '<input type = "text" name="current_weight" value ="'.'">';
	 }
	 echo '</div> </form>';
	?>