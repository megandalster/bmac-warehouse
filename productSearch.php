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
 * Product search module BMAC warehouse
 * @author Noah Jensen
 * @version February 4, 2015
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for Products
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form
					echo('<p><a href="'.$path.'productEdit.php?id=new">Add new product</a>');
					echo('<form method="post">');
						echo('<p><strong>Search for products:</strong>');
						
						if( !array_key_exists('s_product_id', $_POST) ) $product_id = ""; else $product_id = $_POST['s_product_id'];
						echo '&nbsp;&nbsp;Name: ' ;
						echo '<input type="text" name="s_product_id" value="' . $product_id . '">';
						
								
						
                        if( !array_key_exists('s_funding_source', $_POST) ) $funding_source = ""; else $funding_source = $_POST['s_funding_source'];
						echo '<br><br>funding_source:<select name="s_funding_source">';
							echo '<option value=""'; if ($funding_source=="") echo " SELECTED"; echo '>--all--</option>'; 
							echo '<option value="TFAP"'; if ($funding_source=="TFAP") echo " SELECTED"; echo '>TFAP</option>'; 
							echo '<option value="CSFP"'; if ($funding_source=="CSFP") echo " SELECTED"; echo '>CSFP</option>';
							echo '<option value="INK"'; if ($funding_source=="INK") echo " SELECTED"; echo '>INK</option>';
							echo '<option value="Donation"'; if ($funding_source=="Donation") echo " SELECTED"; echo '>Donation</option>'; 
                        echo '</select>';
                        
                       //should create a datepicker java-thingy here for initial date search.
                        
						 if( !array_key_exists('s_status', $_POST) ) $status = ""; else $status = $_POST['s_status'];
						echo '&nbsp;&nbsp;Status:<select name="s_status">';
							echo '<option value=""';            if ($status=="")            echo " SELECTED"; echo '>--all--</option>';
                            echo '<option value="active"';      if ($status=="active")      echo " SELECTED"; echo '>active</option>';
							echo '<option value="discontinued"';    if ($status=="discontinued")    echo " SELECTED"; echo '>discontinued</option>';
                        echo '</select>';
                        
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');	                        
                        
                        //print_r( $_POST );
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						$funding_source = $_POST['s_funding_source'];
						$status = $_POST['s_status'];
                        $product_id = $_POST['s_product_id'];
                        
                        // now go after the products that fit the search criteria
                        include_once('database/dbProducts.php');
                        include_once('domain/Product.php');
                        
                        $result = getonlythose_dbProducts($product_id, $funding_source, $status);  

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
                            if (!$funding_source) echo "product(s)"; 
                            else echo $funding_source.'s';
						if ($product_id!="") echo ' with name like "'.$product_id.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Product ID</strong></td><td><strong>Funding Source</strong></td><td><strong>Status</strong></td><td><strong>Initial Date</strong></td></tr>';
                            
                            foreach ($result as $product) {
								echo "<tr><td><a href=productEdit.php?id=".$product->get_product_id().">" . 
									$product->get_product_id() . "</td><td>" .
									$product->get_funding_source() . "</td><td>" .  
									$product->get_inventory_date() . "</td><td>" .  //change this to get_status() when status is put into the proper db column
									$product->get_initial_date() . "</td><td>"; 
									
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


