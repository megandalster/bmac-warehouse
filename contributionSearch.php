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
 * Contribution search module BMAC warehouse
 * @author Luis Munguia
 * @version February 27, 2015
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for receipts
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
					echo('<p><a href="'.$path.'contributionEdit.php?id=new">Add new receipt</a>');  #Is this alright?
					echo('<form method="post">');
					echo('<p><strong>Search for receipts</strong>');
					echo('<br></br>');
					$receive_date1 = $_POST['s_receive_date1'];	
					$receive_date2 = $_POST['s_receive_date2'];
                        echo 'Date Range from: ' ;
						echo '<input type="text" name="s_receive_date1" value="' . $receive_date1 . '" id="from">';
						echo '&nbsp;&nbsp;to: <input type="text" name="s_receive_date2" value="' . $receive_date2 . '" id="to"></p>';
					$provider_id = $_POST['s_provider_id'];
					echo '<p>Provider name: ' ;
						echo '<input type="text" name="s_provider_id" value="' . $provider_id . '">';
					$receive_items = $_POST['s_receive_items'];  
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;Received items: ' ;
						echo '<input type="text" name="s_receive_items" value="' . $receive_items . '"></p>';
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						$provider_id = $_POST['s_provider_id'];
						$receive_date1 = $_POST['s_receive_date1'];
						$receive_date2 = $_POST['s_receive_date2'];
                        $receive_items = $_POST['s_receive_items'];  
                        // now go after the persons that fit the search criteria
                        include_once('database/dbContributions.php');
                        include_once('domain/Contribution.php');
                        
                        $result = getonlythose_dbContributions($provider_id, $receive_date1, $receive_date2, $receive_items);

						echo '<p><strong>Search Results:</strong>&nbsp;&nbsp;Found ' . sizeof($result). ' ';
                            echo "receipt(s)";
						if ($receive_date1!="" || $receive_date2!="") echo ' within the given date range ';
						if ($provider_id!="") echo ' with provider name like "'.$provider_id.'"';
						if ($receive_items!="") echo ' with received items like "'.$receive_items.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<div id="target" style="overflow: scroll; width: variable; height: 300px;">';
				            echo '<table> <tr><td><strong>Receive Date</strong></td><td><strong>Provider</strong></td>
				                              <td><strong>Product:caselots:weight</strong></td>
				                              <td><strong>Total Weight</strong></td><td><strong>Amount Billed</strong></td></tr>';
                            $allIds = array(); // for printing all provider id's
                            foreach ($result as $contribution) {
                            	$items = $contribution->get_receive_items();
                            	                        	                      	
								echo "<tr><td valign='top'><a href='contributionEdit.php?id=".$contribution->get_receive_date()."'>" .
									pretty_date(substr($contribution->get_receive_date(),0,8)) . "</a></td><td valign='top'>" . 
									$contribution->get_provider_id().  "</td><td>";
                            		foreach($items as $item) {
                            			echo($item."<br>");
                            		} 
									echo "</td><td valign='top'>"; 
									echo $contribution->get_total_weight() . "</td><td valign='top'>" . 
									$contribution->get_billed_amt() . "</td>"; 
								echo "</tr>";
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
