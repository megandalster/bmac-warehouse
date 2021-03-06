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
 * Provider search module BMAC warehouse
 * @author David Quennoz
 * @version February 4, 2015
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for Providers
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form
					echo('<p><a href="'.$path.'providerEdit.php?id=new">Add new provider</a>');
					echo('<form method="get">');
						echo('<p><strong>Search for providers:</strong>');
                        if( !array_key_exists('s_type', $_GET) ) $type = ""; else $type = $_GET['s_type'];
						echo '<br><br>Type:<select name="s_type">';
							echo '<option value=""'; if ($type=="") echo " SELECTED"; echo '>--all--</option>'; 
							echo '<option value="funds"'; if ($type=="funds") echo " SELECTED"; echo '>Funds</option>'; 
							echo '<option value="food"'; if ($type=="food") echo " SELECTED"; echo '>Food</option>';
                        echo '</select>';
                        
                        if( !array_key_exists('s_status', $_GET) ) $status = ""; else $status = $_GET['s_status'];
						echo '&nbsp;&nbsp;Status:<select name="s_status">';
							echo '<option value=""';            if ($status=="")            echo " SELECTED"; echo '>--all--</option>';
                            echo '<option value="active"';      if ($status=="active")      echo " SELECTED"; echo '>Active</option>';
                            echo '<option value="inactive"';      if ($status=="inactive")      echo " SELECTED"; echo '>Inactive</option>';
                        echo '</select>';
                        
						if( !array_key_exists('s_provider_id', $_GET) ) $provider_id = ""; else $provider_id = $_GET['s_provider_id'];
						echo '&nbsp;&nbsp;Name: ' ;
						echo '<input type="text" name="s_provider_id" value="' . $provider_id . '">';
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
                        
                        //print_r( $_GET );
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_GET) ){
						$type = $_GET['s_type'];
						$status = $_GET['s_status'];
                        $provider_id = trim(str_replace('\'','&#39;',htmlentities($_GET['s_provider_id'])));
                        
                        // now go after the persons that fit the search criteria
                        include_once('database/dbProviders.php');
                        include_once('domain/Provider.php');
                        
                        $result = getonlythose_dbProviders($provider_id, $type, $status);  
						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
                            if (!$type) echo "providers(s)"; 
                            else echo $type.' providers(s)';
						if ($provider_id!="") echo ' with name like "'.$provider_id.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Name</strong></td><td><strong>Phone</strong></td><td><strong>Address</strong></td></tr>';
                            foreach ($result as $provider) {
								echo "<tr><td><a href=providerEdit.php?id=".rawurlencode($provider->get_provider_id()).">" . 
									$provider->get_provider_id() . "</td><td>" . 
									$provider->get_nice_phone() . "</td><td>" . 
									$provider->get_address() ."  ". $provider->get_city() ."  ".$provider->get_state() ."  ".$provider->get_zip() ."</td><td>"; 
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


