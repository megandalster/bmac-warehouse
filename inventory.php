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
function inventory_worksheet() {
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php');
    include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 
    echo ("<br><b>Current Inventory Worksheet<br></b> Worksheet date: ".date("F d, Y")."<br><br>");
	 echo "<br><br><table><tr><td width='170px'><b>Product Name</b></td><td><b>Funding Source</b></td><td><b>Unit Weight</b></td><td><b>Last Inventory Date</b></td><td><b>Last Inventory Case Lots</b></td><td><b>Case Lots Weight</b></td>";
	 echo "<td><b>Shipments Number</b></td><td><b>Shipments Weight</b></td><td><b>Receipts Number</b></td><td><b>Receipts Weight</b></td><td><b>Current Stock Case Lots</b></td><td><b>Current Weight</b></td>";
	 $products = getall_dbProducts();
	 echo '<form method ="post"><div id="target" style = flow: scroll; width: variable; height: 300px;">';
	 foreach ($products as $product){
	 	if ($history) $last_inventory = end($history);
	 	else $last_inventory = "UNKNOWN" ;
	 	$ship_items = count_shipments($product_id, $funding_source);
	 	$receive_items = count_receipts($product_id, $funding_source);
	 	$initial_stock = reset($product_get_history());
	 	if ($last_inventory=="UNKNOWN"){
	 		$initial_stock_array = explode(":",$initial_stock_array);
	 		$receive_items_array = explode(":",$receive_items_array);
	 		$ship_items_array = explode(":",$ship_items_array);
	 		$estimated_stock = $initial_stock_array[1] + $receive_items_array[1] - $ship_items_array[1].":"."WEIGHT";
	 	}
	 	else $current_stock = $last_inventory;
	 	// display a line in the table
	 	echo "<br>".$product->get_id() .
	 		 $product ->get_funding_source().
	 		 $product_get_unit_weight .
	 		 $last_inventory .
	 		 $ship_items .
	 		 $receive_items  .
	 		 '<input type = "text" name="current_case_lots" value ="'.'">' .
	 		 '<input type = "text" name="current_weight" value ="'.'">';
	 }
	echo '</div> </form>';
}
	?>