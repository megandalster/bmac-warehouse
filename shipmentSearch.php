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
                        
						// Lay out the three search boxes
						if( !array_key_exists('s_customer_id', $_POST) ) $customer_id = ""; else $customer_id = $_POST['s_customer_id'];
						echo '<br><br>';
						echo '&nbsp;&nbsp;Customer Name: ' ;
						echo '<br><br>';
						//Change this to whatever I want displayed in text area
						echo '<input type="text" name="s_customer_id" value="' . $customer_id . '">';
						echo '<br><br>';
						
						if( !array_key_exists('s_ship_date', $_POST) ) $ship_date = ""; else $ship_date = $_POST['s_ship_date'];
						echo '&nbsp;&nbsp;Date Range: ' ;
						echo '<br><br>';
						//Change this to whatever I want displayed in text area
						echo '<input type="text" name="s_ship_date" value="' . $ship_date . '">';
						//echo '<input type="text" name="s_name" value="' . $ship_date . '">';
						
						if( !array_key_exists('s_ship_items', $_POST) ) $ship_items = ""; else $ship_items = $_POST['s_ship_items'];
						echo '<br><br>';
						echo '&nbsp;&nbsp; Product: ';
						echo '<br><br>';
						//Change this to whatever I want displayed in text area
						echo '<input type="text" name="s_ship_items" value="' . $ship_items . '">';
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
						
					
                        //print_r( $_POST );
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						$customer_id = $_POST['s_customer_id'];
						$ship_date = $_POST['s_ship_date'];
						$ship_items = $_POST['s_ship_items'];
                       
                        // now go after the persons that fit the search criteria
                        include_once('database/dbShipments.php');
                        include_once('domain/Shipment.php');
                        
                        $result = getonlythose_dbShipments($customer_id, $ship_date, $ship_items);  

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
							if (!ship_items) echo "shipment(s)";
							else echo 'shipment(s)';
                        if ($customer_id!="") echo ' with Customer Name like "'.$customer_id.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Customer Name</strong></td><td><strong>Ship Date</strong></td><td><strong>Product</strong></td></tr>';
                            foreach ($result as $shipment) {
								echo "<tr><td><a href=shipmentEdit.php?id=".$shipment->get_customer_id().">" . 
									$shipment->get_customer_id() . "</td><td>" . 
									$shipment->get_ship_date() . "</td><td>" . 
									implode(",",$shipment->get_ship_items() ). "</td><td>"; 
								
								echo "</td></a></tr>";
							}
							
							echo '</table>';
							/*
							echo "<br/><strong>Email these people:</strong> <br/>";
	                        foreach($allEmails as $email)
	                            if ($email!="")
	                              echo $email . ", ";
	                              */
						}
						
                        
                        
						
					}
				?>
				<!-- below is the footer that we're using currently-->
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>


