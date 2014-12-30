<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 * A form that offers the ability to search for donors in the database.
 * 
 * @author Kevin Tabb & Nick Wetzel
 * @version December 21, 2013
 */
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<title>
			Search for Donors
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
				// display the search form

				echo('<p><b>Search for Donors</b><br>');
				// form
				echo('<form method="post" action="donorSearch.php">');
					// table
					echo '<p><table> <tr><td><strong>Name:</strong></td><td><strong>City:</strong></td></tr>';
						// contents (two text fields for searching and button to search)
						echo "<td><input type='text' name='Name'>&nbsp;&nbsp;</td>";
						echo "<td><input type='text' name='City'>&nbsp;&nbsp;</td>";
						echo "<td><button type='submit' name='Search'>Search</button></td>";
						echo "<td><button type='submit' value='new' name='id' form='donor_form'>Add New Donor</button></td>";
					echo "</table>";
				echo "</form></p>";   
				
				// if user hit "Search"  button, query the database and display the results
				if( array_key_exists('Search', $_POST) ){

                    include_once('database/dbDonors.php');
     				include_once('domain/Donor.php');
     				
					$name = $_POST['Name'];
					$city = $_POST['City'];
					
					// new method based on the old getall_donors
					$result = getall_donorsFiltered($name, $city);
					
                    echo "<p><strong>Search Results:</strong> <p>Found " . sizeof($result). " donor(s)";

					if (sizeof($result)>0) {
						echo ' (select one for more info).';
						// display results in a table
						echo '<p><table><tr><td class="padded"><b>Name</b></td><td class="padded"><b>Phone</b></td>';
						echo '<td class="padded"><b>Address</b></td><td class="padded"><b>City</b></td>';
						echo '<td class="padded"><b>State</b></td><td class="padded"><b>Zip</b></td></tr>';
						foreach ($result as $donor) {
							echo 
								"<tr><td class='padded'><a href='donorEdit.php?id=" . $donor->get_id() ."'>" .
								$donor->get_id() . "</td><td class='padded'>" . 
								$donor->get_phone1() . "</td><td class='padded'>" .
								$donor->get_address() . "</td><td class='padded'>" .
								$donor->get_city() . "</td><td class='padded'>" .
								$donor->get_state() . "</td><td class='padded'>" .
								$donor->get_zip() . "</td><td class='padded'></td></a></tr>";
						}
					}
					echo '</table>';
				}
					
				?>
			</div>
				<!-- Form to take us to the donor adding template -->
				<form id="donor_form" action="donorEdit.php" method="get"></form>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>

