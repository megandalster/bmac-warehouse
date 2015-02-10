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
 * @version February 4, 2015
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
					echo('<p><a href="'.$path.'personEdit.php?id=new">Add new receipt</a>');
					echo('<form method="post">');
						echo('<p><strong>Search for receipts:</strong>');
                        if( !array_key_exists('s_type', $_POST) ) $type = ""; else $type = $_POST['s_type'];
						echo '<br><br>Type:<select name="s_type">';
							echo '<option value=""'; if ($type=="") echo " SELECTED"; echo '>--all--</option>'; 
							echo '<option value="staff"'; if ($type=="staff") echo " SELECTED"; echo '>Warehouse Staff</option>'; 
							echo '<option value="office"'; if ($type=="office") echo " SELECTED"; echo '>Office Staff</option>';
							echo '<option value="manager"'; if ($type=="manager") echo " SELECTED"; echo '>Foodbank Director</option>'; 
                        echo '</select>';
                        
                        if( !array_key_exists('s_status', $_POST) ) $status = ""; else $status = $_POST['s_status'];
						echo '&nbsp;&nbsp;Status:<select name="s_status">';
							echo '<option value=""';            if ($status=="")            echo " SELECTED"; echo '>--all--</option>';
                            echo '<option value="active"';      if ($status=="active")      echo " SELECTED"; echo '>Active</option>';
							echo '<option value="on-leave"';    if ($status=="on-leave")    echo " SELECTED"; echo '>On Leave</option>';
                            echo '<option value="former"';      if ($status=="former")      echo " SELECTED"; echo '>Former</option>';
                        echo '</select>';
                        
						if( !array_key_exists('s_name', $_POST) ) $name = ""; else $name = $_POST['s_name'];
						echo '&nbsp;&nbsp;Name: ' ;
						echo '<input type="text" name="s_name" value="' . $name . '">';
						
						echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
						echo('</form></p>');
                        
                        //print_r( $_POST );
					
				// if user hit "Search"  button, query the database and display the results
					if( array_key_exists('s_submitted', $_POST) ){
						$type = $_POST['s_type'];
						$status = $_POST['s_status'];
                        $name = trim(str_replace('\'','&#39;',htmlentities($_POST['s_name'])));
                        
                        // now go after the persons that fit the search criteria
                        include_once('database/dbPersons.php');
                        include_once('domain/Person.php');
                        
                        $result = getonlythose_dbPersons($type, $status, $name);  

						echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result). ' ';
                            if (!$type) echo "person(s)"; 
                            else echo $type.'s';
						if ($name!="") echo ' with name like "'.$name.'"';
						if (sizeof($result)>0) {
							echo ' (select one for more info).';
							echo '<p><table> <tr><td><strong>Name</strong></td><td><strong>Phone</strong></td><td><strong>E-mail</strong></td></tr>';
                            $allEmails = array(); // for printing all emails
                            foreach ($result as $person) {
								echo "<tr><td><a href=personEdit.php?id=".$person->get_id().">" . 
									$person->get_last_name() .  ", " . $person->get_first_name() . "</td><td>" . 
									$person->get_nice_phone1() . "</td><td>" . 
									$person->get_email() . "</td><td>"; 
									$allEmails[] = $person->get_email();
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

