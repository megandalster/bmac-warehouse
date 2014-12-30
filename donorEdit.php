<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).dbDonors
 */

/**
 *  Implements the editing of a donor to be added, changed, or deleted from the database.
 *  
 *	@author Nick Wetzel & Hartley Brody
 *	@version October 21, 2013
 */
	session_start();
	session_cache_expire(30);
	
    include_once('database/dbDonors.php');
    include_once('domain/Donor.php');
	
    // get the ID of the donor
	$id = $_GET['id'];
	
	// if new then create a new donor
	if($id == 'new'){
		$donor = new Donor("","","","","","","","","","","","",""); 	
	}
	// else pull the existing donor from the database
	else{
		$donor = retrieve_dbDonors($id);
		if(!$donor){
	         echo('<p id="error">Error: Sorry, there is no donor in the database with the given ID: ' .$id. '</p>');
		     die();
        }
	}
	
?>
<html>
<head>
	<title>Donor Edit</title>
	<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
	
<body>
<div id="container">
    <?php include('header.php');?>
    
	<div id="content">
	<?php
	include('donorValidate.php');
	
	if(!array_key_exists('_form_submit', $_POST)){
		// in this case, the form has not been submitted, so show it
		include('donorForm.php');
	}
	else{
		// in this case, the form has been submitted, so validate it
		$errors = validate_form($id); // step one is validation, "errors" array lists problems on the form submitted
		
		if($errors){	
			show_errors($errors); // display the errors on the form to fix	
			
			// is this a new donor?
			if($id == "new"){
				$id = trim(stripslashes(htmlentities(str_replace('&','and',str_replace('#',' ',$_POST['id']))))); // sanitize the id
			}
        	$donor = new Donor($id, $_POST['month_name'], $_POST['day_name'], $_POST['year_name'], $_POST['type'], 
        					   $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['neighborhood'], $_POST['phone1'],
        			           $_POST['email'], $_POST['notes']);
        	
			include('donorForm.php');
			// this was a successful form submission; update the database and exit
		}
		else{
			process_form($id);
		}
		echo('</div>');
		include('footer.inc');
		echo('</div></body></html>');
		die();
	}

/**
* This method sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($id){
	
		// sanitize data by replacing HTML entities and escaping the ' character
		if($id=="new"){
			$id = trim(stripslashes(htmlentities(str_replace('&','and',str_replace('#',' ',$_POST['id'])))));
		}
		$month_name =   trim(stripslashes(htmlentities($_POST['month_name'])));
		$day_name =   trim(stripslashes(htmlentities($_POST['day_name'])));
		$year_name =   trim(stripslashes(htmlentities($_POST['year_name'])));
		$type =   trim(stripslashes(htmlentities($_POST['type'])));
		$address =      trim(stripslashes(htmlentities($_POST['address'])));
		$city =         trim(stripslashes(htmlentities($_POST['city'])));
		$state =        trim(stripslashes(htmlentities($_POST['state'])));
		$zip =          trim(stripslashes(htmlentities($_POST['zip'])));
        $neighborhood = trim(stripslashes(htmlentities($_POST['neighborhood'])));
        
		$phone1 = trim(stripslashes(str_replace(' ','',htmlentities($_POST['phone1']))));
		$clean_phone1 = preg_replace("/[^0-9]/", "", $phone1);
		
		$email =   trim(stripslashes(htmlentities($_POST['email'])));
		$notes = $_POST['notes'];

        // try to make the deletion, addition, or change
		if($_POST['deleteMe'] == "DELETE"){
			$result = retrieve_dbDonors($id);
			if(!$result)
				echo('<p>Unable to delete. <b>' . $id . '</b> is not in the database. <br>Please report this error to the Program Coordinator.');
			else{
                $result = delete_dbDonors($id);
                echo("<p>You have successfully removed <b>" . $id . "</b> from the database.</p>");		
            }
		}

		// try to add a new donor to the database
		else if($_POST['old_id'] == 'new'){
			//check if there's already an entry
			$dup = retrieve_dbDonors($id);
			if($dup)
				echo('<p class="error">Unable to add <b>' . $id . '</b> to the database. <br>Another donor with the same id is already there.');
			else{
				$newDonor = new Donor($id, $month_name, $day_name, $year_name, $type, $address, $city, $state, $zip,
	                       			  $neighborhood, $phone1, $email, $notes);
	            $result = insert_dbDonors($newDonor); 
                if(!$result)
               		echo ('<p class="error">Unable to add <b>'. $id . '</b> in the database. <br>Please report this error to the Program Coordinator.');
				else{ 
					echo("<p>You have successfully added <b><a href='donorEdit.php?id=" . $id. "'>".$id."</a></b> to the database.</p>");
					
					// determine which donation form to move back to
					switch($_GET['donation_type']){
						case "1": echo('<p><a href="viewDonation1.php?donationID=new">Return to Donation Form</a></p>');
								  break;
								  
        				case "2": echo('<p><a href="viewDonation2.php?donationID=new">Return to Donation Form</a></p>');
        						  break; 
					}
				}
			}
		}

		// try to replace an existing donor in the database by removing and adding
		else{
			$id = $_POST['old_id'];
        	
			$result = delete_dbDonors($id);	
            if(!$result){
             	echo ('<p class="error">Unable to update <b>' .$id. '</b>. <br>Please report this error to the Program Coordinator.');
           	}
			else{
				$newDonor = new Donor($id, $month_name, $day_name, $year_name, $type, $address, $city, $state, $zip,
	                       			  $neighborhood, $phone1, $email, $notes);
                $result = insert_dbDonors($newDonor);
				if(!$result)
                   	echo ('<p class="error">Unable to update <b>' .$id. '</b>. <br>Please report this error to the Program Coordinator.');
				else 
					echo("<p>You have successfully updated <b><a href='donorEdit.php?id=" . $id. "'>".$id."</a></b> in the database.</p>");
			}
		}
}
?>
    </div>
	<?php include('footer.inc');?>		
</div>
</body>
</html>
