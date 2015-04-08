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
						echo '<option value=""'; echo " SELECTED"; echo '>--any--</option>';
    echo('<option value="TFAP"'); echo('>TFAP</option>');
	echo '<option value="CSFP"'; echo '>CSFP or 2CSFP</option>';
	echo '<option value="INK"'; echo '>INK</option>';
	echo '<option value="AFF"'; echo '>AFF</option>';
	echo '<option value="FC"'; echo '>FC</option>';
	echo '<option value="F.D."'; echo '>F.D.</option>';
	echo '<option value="SP"'; echo '>SP</option>';
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

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' product(s)'; 
						if ($product_id!="") echo ' with name like "'.$product_id.'"';
						if ($funding_source!="") echo ' with funding source like "'.$funding_source.'"';
						if ($status!="") echo ' with status "'.$status.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<div id="target" style="overflow: scroll; width: 600px; height: 200px;">';
				            echo '<p><table> <tr><td><strong>Product ID</strong></td><td><strong>Funding Source</strong></td><td><strong>Status</strong></td><td><strong>Initial Date</strong></td></tr>';
                            
                            foreach ($result as $product) {
								echo "<tr><td><a href=productEdit.php?id=".urlencode($product->get_product_id())."&fundingsource=".urlencode($product->get_funding_source()).">" . 
									$product->get_product_id() . "</td><td>" .
									$product->get_funding_source() . "</td><td>" .  
									$product->get_status() . "</td><td>" . 
									$product->get_initial_date() . "</td><td>"; 			
								echo "</td></a></tr>";
							}
							echo '</table>';
							echo '</div>';
						}
						
					}
				?>
				<!-- below is the footer that we're using currently-->
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>


