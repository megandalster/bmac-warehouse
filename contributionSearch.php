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
			Search for Contributions
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form
					echo('<p><a href="'.$path.'contributionEdit.php?id=new">Add new contribution</a>');  #Is this alright?
					echo('<form method="post">');
					echo('<p><strong>Search for contributions:</strong>');
					
                    if( !array_key_exists('s_provider_id', $_POST) ) $provider_id = ""; else $provider_id = $_POST['s_provider_id'];
					echo '&nbsp;&nbsp;Provider name: ' ;
						echo '<input type="text" name="s_provider_id" value="' . $provider_id . '">';
						
					if( !array_key_exists('s_receive_date1', $_POST) ) $receive_date1 = ""; else $receive_date1 = substr($_POST['s_receive_date1'],2).":00:00";
					if( !array_key_exists('s_receive_date2', $_POST) ) $receive_date2 = ""; else $receive_date2 = substr($_POST['s_receive_date2'],2).":23:59";
					echo '&nbsp;&nbsp;Date Range: ' ;
						echo '<input type="text" name="s_receive_date1" value="' . $receive_date1 . '">';
						echo '<input type="text" name="s_receive_date2" value="' . $receive_date2 . '">';
						
					if( !array_key_exists('s_receive_items', $_POST) ) $receive_items = ""; else $receive_items = $_POST['s_receive_items'];
					echo '&nbsp;&nbsp;Product: ' ;
						echo '<input type="text" name="s_receive_items" value="' . $receive_items . '">';
					
					
					
						
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
                        
					
						
						
                        //print_r( $_POST );
                        //echo($receive_date1);
					
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
                            echo "contribution(s)";
						if ($provider_id!="") echo ' with provider id like "'.$provider_id.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Provider id</strong></td><td><strong>Receive date</strong></td><td><strong>Items received</strong></td><td><strong>Payment Source</strong></td><td><strong>Amount billed</strong></td></tr>'; #What info do i show
                            $allIds = array(); // for printing all provider id's
                            foreach ($result as $contribution) {
								echo "<tr><td><a href=contributionEdit.php?id=".$contribution->get_provider_id().">" .
									$contribution->get_provider_id() . "</td><td>" . 
									$contribution->get_receive_date() .  "</td><td>" .
									implode(',',$contribution->get_receive_items()) . "</td><td>" . 
									$contribution->get_payment_source() . "</td><td>" . 
									$contribution->get_billed_amt() . "</td><td>"; 
									$allNotes[] = $contribution->get_notes();
								echo "</td></a></tr>";
							}
							echo '</table>';  
							echo "<br/><strong>Contributions with notes:</strong> <br/>";  #What to do with this?
	                        foreach($allNotes as $notes)
	                            if ($notes!="")
	                              echo $notes . ", ";
						}
						
                        
                        
						
					}
				?>
				<!-- below is the footer that we're using currently-->
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>

