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
					echo('<p><strong>Search for receipts:</strong>');
					$provider_id = $_POST['s_provider_id'];
					echo '<br><br><p>Provider name: ' ;
						echo '<input type="text" name="s_provider_id" value="' . $provider_id . '"></p>';
					$receive_date1 = $_POST['s_receive_date1'];	
					$receive_date2 = $_POST['s_receive_date2'];
                        echo '<p>Date Range from: ' ;
						echo '<input type="text" name="s_receive_date1" value="' . $receive_date1 . '" id="from">';
						echo '&nbsp;&nbsp;to: <input type="text" name="s_receive_date2" value="' . $receive_date2 . '" id="to"></p>';
					$receive_items = $_POST['s_receive_items'];  
                        echo '<p>Items received: ' ;
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

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
                            echo "receipt(s)";
						if ($provider_id!="") echo ' with provider id like "'.$provider_id.'"';
						if ($receive_date1!="" || $receive_date2!="") echo ' within the given date range ';
						if ($receive_items!="") echo ' with received items like "'.$receive_items.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Receive Date</strong></td><td><strong>Provider</strong></td><td><strong>Items</strong></td><td><strong>Payment Source</strong></td><td><strong>Amount Billed</strong></td></tr>'; #What info do i show
                            $allIds = array(); // for printing all provider id's
                            foreach ($result as $contribution) {
								echo "<tr><td><a href='contributionEdit.php?id=".$contribution->get_receive_date()."'>" .
									$contribution->get_receive_date() . "</a></td><td>" . 
									$contribution->get_provider_id().  "</td><td>" .
									implode(',',$contribution->get_receive_items()) . "</td><td>" . 
									$contribution->get_payment_source() . "</td><td>" . 
									$contribution->get_billed_amt() . "</td><td>"; 
									$allNotes[] = $contribution->get_notes();
								echo "</td></a></tr>";
							}
							echo '</table>';  
						}    
					}
				?>
				<!-- below is the footer that we're using currently-->
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>
