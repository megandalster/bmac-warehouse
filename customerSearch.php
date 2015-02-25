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
 * Customer search module BMAC warehouse
 * @author Moustafa ElBadry
 * @version February 16, 2015
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for Customers
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form
					echo('<p><a href="'.$path.'customerEdit.php?id=new">Add new customer</a>');
					echo('<form method="post">');
						echo('<p><strong>Search for customers:</strong><p>');
                        
                        
                        if( !array_key_exists('s_status', $_POST) ) $status = ""; else $status = $_POST['s_status'];
						echo '&nbsp;&nbsp;Status:<select name="s_status">';
							echo '<option value=""';            if ($status=="")            echo " SELECTED"; echo '>--all--</option>';
                            echo '<option value="active"';      if ($status=="active")      echo " SELECTED"; echo '>Active</option>';
							echo '<option value="on-leave"';    if ($status=="on-leave")    echo " SELECTED"; echo '>On Leave</option>';
                            echo '<option value="former"';      if ($status=="former")      echo " SELECTED"; echo '>Former</option>';
                        echo '</select>';
                        
                      //  if( !array_key_exists('s_customer_id', $_POST) ) $customer_id = ""; else $cutomer_id = $_POST['s_customer_id'];
					//	echo '&nbsp;&nbsp; Customer ID: ' ;
					//	echo '<input type="text" name="s_customer_id" value="' . $customer_id . '">';
						
				//		echo('<p><input type="hidden" customer_id="s_submitted" value="1"><input type="submit" customer_id="Search" value="Search">');
				//		echo('</form></p>');
                                                
                        
						if( !array_key_exists('s_name', $_POST) ) $name = ""; else $name = $_POST['s_name'];
						echo '&nbsp;&nbsp; Customer Name: ' ;
						echo '<input type="text" name="s_name" value="' . $name . '">';
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
                        
                        //print_r( $_POST );
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						
						$status = $_POST['s_status'];
                        $name = trim(str_replace('\'','&#39;',htmlentities($_POST['s_name'])));
                        
                        // now go after the customers that fit the search criteria
                        include_once('database/dbCustomers.php');
                        include_once('domain/Customer.php');
                        
                        $result = getonlythose_dbCustomers($status, $name);  

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
                            
						if ($name!="") echo ' with name like "'.$name.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Name</strong></td><td><strong>Phone</strong></td><td><strong>E-mail</strong></td></tr>';
                            $allEmails = array(); // for printing all emails
                            foreach ($result as $customer) {
								echo "<tr><td><a href=customerEdit.php?id=".$customer->get_customer_id().">" . 
									$customer->get_phone() .  ", " . $customer->get_city() . "</td><td>" . 
									$customer->get_state() . "</td><td>" . 
									$customer->get_email() . "</td><td>"; 
									$allEmails[] = $customer->get_email();
								echo "</td></a></tr>";
							}
							echo '</table>';
							echo "<br/><strong>Email these people:</strong> <br/>";
	                        foreach($allEmails as $email)
	                            if ($email!="")
	                              echo $email . ", ";
						}
						
                        
                        
						
					}
				?>
				<!-- below is the footer that we're using currently-->
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>

