<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
/**
 * 
 * Shipment search module BMAC warehouse
 * @author Dylan Martin
 * @version February 23, 2015
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for Shipments
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
		<script>
		$(function() {
			$( "#from" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
			$( "#to" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
		});
		</script>
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form
					echo('<p><a href="'.$path.'shipmentEdit.php?id=new">Add new shipment</a>');
					echo('<form method="post">');
						echo('<p><strong>Search for shipments:</strong>');
                        echo('<br></br>');
						// Lay out the three search boxes
						
						$ship_date1 = $_POST['s_ship_date1'];	
					    $ship_date2 = $_POST['s_ship_date2'];
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;Date Range from: ' ;
						echo '<input type="text" name="s_ship_date1" value="' . $ship_date1 . '" id="from">';
						echo '&nbsp;&nbsp;to: <input type="text" name="s_ship_date2" value="' . $ship_date2 . '" id="to">';if( !array_key_exists('s_ship_date', $_POST) ) $ship_date = ""; else $ship_date = $_POST['s_ship_date'];
						
						$customer_id = $_POST['s_customer_id'];
						echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;Customer Name: ' ;
						//Change this to whatever I want displayed in text area
						echo '<input type="text" name="s_customer_id" value="' . $customer_id . '">';
						$ship_items = $_POST['s_ship_items'];
						echo '&nbsp;&nbsp;&nbsp;&nbsp;Product: ';
						echo '<input type="text" name="s_ship_items" value="' . $ship_items . '">';
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						$customer_id = $_POST['s_customer_id'];
						$ship_date1 = $_POST['s_ship_date1'];
						$ship_date2 = $_POST['s_ship_date2'];
						$ship_items = $_POST['s_ship_items'];
                       
                        // now go after the persons that fit the search criteria
                        include_once('database/dbShipments.php');
                        include_once('domain/Shipment.php');
                        $result = getonlythose_dbShipments($customer_id, $ship_date1, $ship_date2, $ship_items);  

						echo '<p><strong>Search Results:</strong> &nbsp;&nbsp;&nbsp;&nbsp;Found ' . sizeof($result). ' shipment(s)';
                        if ($customer_id!="") echo ' with Customer Name like "'.$customer_id.'"';
                        if ($ship_date1!="" || $ship_date2!="") echo ' within the given date range ';
						if ($ship_items!="") echo ' with shipped items like "'.$ship_items.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<div id="target" style="overflow: scroll; width: variable; height: 300px;">';
				            echo '<p><table> <tr><td><strong>Ship Date</strong></td><td><strong>Customer Name</strong></td><td><strong>Products</strong></td></tr>';
                            foreach ($result as $shipment) {
								echo "<tr><td valign='top'><a href=shipmentEdit.php?id=".urlencode($shipment->get_ship_date()).">" . 
									pretty_date(substr($shipment->get_ship_date(),0,8)) . "</td><td valign='top'>" . 
									$shipment->get_customer_id() . "</td><td valign='top'>" . 
									implode("<br>",$shipment->get_ship_items() ). "</td><td>"; 	
								echo "</td></a></tr>";
							}
							echo '</table>';
							echo '</div>';
						}
					}
				function pretty_date($yy_mm_dd) {
					return date('M j, Y', mktime(0,0,0,substr($yy_mm_dd,3,2),substr($yy_mm_dd,6,2),substr($yy_mm_dd,0,2)));
				}
				?>
				<!-- below is the footer that we're using currently-->
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>


