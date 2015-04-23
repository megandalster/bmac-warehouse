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
date_default_timezone_set('America/Los_Angeles');
                	
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
     echo "<p style='font-size:12pt'><b>Current Inventory Worksheet</b><br> Today's date: ".date('F d, Y')."<br>";
	 echo '<form method ="post">';
	 
	 if( !array_key_exists('s_product_id', $_POST) ) $product_id = "a"; else $product_id = $_POST['s_product_id'];
	 echo '<p style="font-size:12pt">Show all active products with names that begin with: ' ;
	 echo '<input type="text" style="width:100px;font-size:12pt" name="s_product_id" value="' . $product_id . '">';
	 
	 $products = getproducts_beginningwith($product_id);
	 $today = date('y-m-d');	 					
     
	  // now update the $history of the products
	 if ( $_POST['s_update'] ) {
	 	$today = date('y-m-d');
	 	if ($_POST['undo_it']) $undo=$_POST['undo_it']; else $undo=array();
	 	$changesw = false;
	 	foreach($undo as $index) {
	 		$changesw = true;
	 		$products[$index] -> remove_from_history();
	 		update_dbProducts($products[$index]);
	 	}
	 	for ($i=0; $i<count($products);++$i) {
	 		$product = $products[$i];
	 		$pcl = $_POST['current_case_lots'][$i];
	 		$pwt = $_POST['current_weight'][$i];
	 		if ($pcl!="" || $pwt!="") {
	 			$changesw = true;
	 			// calculate case lots or total wt if possible -- otherwise, accept whatever is entered
	 			if ($pcl=="" && $product->get_unit_weight()>0)
	 				$pcl = intval($pwt / $product->get_unit_weight());
	 			elseif ($pwt=="" && $product->get_unit_weight()>0)
	 				$pwt = intval($pcl * $product->get_unit_weight());
	 			$new_entry = $today.":".$pcl.":".$pwt;
	 			$product->add_to_history($new_entry);
	 			update_dbProducts($product);
	 			$_POST['current_case_lots'][$i] = "";
	 			$_POST['current_weight'][$i] = "";
	 		}
	 	}
	 	if ($changesw) 
	 		echo "<p style='font-size:12pt'> Inventory database has been updated (see changes below).";			
	 }
	     $products = getproducts_beginningwith($product_id);	
	     echo "<p style='font-size:12pt'>".count($products)." products are listed below (scroll to see all of them).";	
	     echo "<p><table class='inventable'><tr><td></td><td>Funding</td><td>Unit</td>".
		      "<td colspan=4 width=180>Last Inventory</td><td colspan=2 width=80>Shipments</td><td colspan=2 width=80>Receipts</td><td colspan=2>Current Stock</td></tr>";
		 echo "<tr><td width=150>Product</td><td>Source</td><td>Weight</td><td>Date</td><td>Units</td><td>Wt</td><td>Undo</td>".
		      "<td>No</td><td>Total Wt</td><td>No</td><td>Total Wt</td>".
		      "<td>Units</td><td>Weight</td></tr></table>";
		 echo '<div id="target" style="overflow: scroll; width: variable; height: 250px;">';
		 echo "<p><table class='inventable'>";
		 $list_index = 0;
		 foreach ($products as $product){
		 	echo "<tr>";
		 	if (count($product->get_history())>0) 
		 		$last_inventory = explode(":",end($product->get_history()));  // the array [date,caselots,weight]
		 	else 
		 		$last_inventory = explode(":","::") ;
		 	$ship_items = explode(":",count_shipments($product->get_product_id(), $product->get_funding_source(),$last_inventory[0],""));   // the array [number,weight]
		 	$receive_items = explode(":",count_receipts($product->get_product_id(), $product->get_funding_source(),$last_inventory[0],"")); // the array [number,weight]
		    $estimated_stock = $last_inventory[2] + $receive_items[1] - $ship_items[1];
		 	// display a line in the table
		 	echo "<td class='inventable' width=150>".$product->get_product_id() . "</td>".
		 		 "<td width=20>".$product->get_funding_source(). "</td>".
		 		 "<td width=40 align='right'>".$product->get_unit_weight(). "</td>". 
		 		 "<td width=40 align='right'>".pretty_date($last_inventory[0]) .
		 		     "</td><td width=20 align='right'>".$last_inventory[1] .
		 		     "</td><td width=40 align='right'>".$last_inventory[2] ."</td>";
		 	echo '<td><input type = "checkbox" style="font-size:12pt" name="undo_it[]" value="'.$list_index.'"></td>';
		 	echo "<td width=20 align='right'>".$ship_items[0] ."</td><td width=40 align='right'>".$ship_items[1] ."</td>".
		 		 "<td width=40 align='right'>".$receive_items[0]  ."</td><td width=40 align='right'>".$receive_items[1] ."</td>".
		 		 '<td width=60 align="right"><input type = "text" style="width:50px;font-size:12pt" name="current_case_lots[]" value="'.
		 				$_POST['current_case_lots'][$list_index].'"></td>' .
		 		 '<td width=20 ><input type = "text" style="width:50px;font-size:12pt" name="current_weight[]" value="'.
		 				$_POST['current_weight'][$list_index].'"></td>';
		 	     
		    echo "</tr>";
		    $list_index++;
		 }
		 echo '</table></div>';
		 
		 echo '<p style="font-size:12pt">When finished, hit ' .
		  '<input type="submit" name="s_update" style="font-size:12pt" value="Update"> to update the inventory with your changes.</p>';
		 
	     echo '</form>';
	 
	 function pretty_date($d) {
	 	if ($d=="")
	 	    return "";
	 	if ($d==date('y-m-d'))
	 		return "&nbsp;&nbsp;Today!";
	 	return date('m/d/y',mktime(0,0,0,substr($d,3,2),substr($d,6,2),substr($d,0,2)));
	 }
 	?>	
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>