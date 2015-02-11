<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 *	personEdit.php
 *  oversees the editing of a person to be added, changed, or deleted from the database
 *	@author Allen Tucker
 *	@version December 29, 2014
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbPersons.php');
    include_once('domain/Person.php'); 
    
//    include_once('database/dbLog.php');
	$id = $_GET["id"];
	if ($id=='new') {
	 	$person = new Person(null,'new',null,null,null,null,null,null,null,null,null,
	 	     	null,md5("new"));
	}
	else {
		$person = retrieve_dbPersons($id);
		if (!$person) {
	         echo('<p id="error">Error: there\'s no person with this id in the database</p>'. $id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($person->get_first_name()." ".$person->get_last_name());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
<body>
  <div id="container">
    <?PHP include('header.php');?>
	<div id="content">
<?PHP
	include('personValidate.inc');
	if($_POST['_form_submit']!=1){
	//in this case, the form has not been submitted, so show it
			include('personForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
		if ($_POST['availability']==null)
			   $avail = "";
		else $avail = implode(',',$_POST['availability']);
		if ($id=='new') {
				$first_name = trim($_POST['first_name']);
				$last_name = $_POST['last_name'];
				$phone1 = $_POST['phone1'];
		}
		else {
				$first_name = $person->get_first_name();
				$last_name = $person->get_last_name();
				$phone1 = $person->get_phone1();
		}
		$person = new Person($last_name, $first_name, $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'],
								 $phone1, $_POST['phone2'], $_POST['email'], $_POST['type'],
								 $_POST['status'], $_POST['notes'], $_POST['old_pass']);
		$errors = validate_form($id); 	//step one is validation.
									// errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('personForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($id, $person);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($id, $person)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($id=='new') {
			    $first_name = trim(str_replace('\\\'','',htmlentities(trim($_POST['first_name']))));
				$last_name = trim(str_replace('\\\'','\'',htmlentities($_POST['last_name'])));
				$phone1 = trim(str_replace(' ','',htmlentities($_POST['phone1'])));
				$clean_phone1 = preg_replace("/[^0-9]/", "", $phone1);
		}
		else {
				$first_name = $person->get_first_name();
				$last_name = $person->get_last_name();
				$phone1 = $person->get_phone1();
				$clean_phone1 = $phone1;
		}
		$address = trim(str_replace('\\\'','\'',htmlentities($_POST['address'])));
		$city = trim(str_replace('\\\'','\'',htmlentities($_POST['city'])));
		$state = trim(htmlentities($_POST['state']));
		$zip = trim(htmlentities($_POST['zip']));
		$phone2 = trim(str_replace(' ','',htmlentities($_POST['phone2'])));
		$clean_phone2 = preg_replace("/[^0-9]/", "", $phone2);
		$email = $_POST['email'];
		$type = $_POST['type'];			
        $status = $_POST['status'];
        $notes = trim(str_replace('\\\'','\'',htmlentities($_POST['my_notes'])));
		$pass = $_POST['password'];
		
		$newperson = new Person($last_name, $first_name, $address, $city, $state, $zip, $clean_phone1, 
						$clean_phone2, $email, $type, $status, $notes, $pass);
        
	//step two: try to make the deletion, password change, addition, or change
		if($_POST['deleteMe']=="DELETE"){
			$result = retrieve_dbPersons($id);
			if (!$result)
				echo('<p>Unable to delete. ' .$first_name.' '.$last_name. ' is not in the database. <br>Please report this error to the House Manager.');
			else {
				//What if they're the last remaining manager account?
				if($type=='manager'){
				//They're another manager, we need to check that they can be deleted
					$managers = getonlythose_dbPersons('manager','','');
					if ($id==$_SESSION['_id'] || !$managers || sizeof($managers) <= 1)
						echo('<p class="error">You cannot remove yourself or the last remaining manager from the database.</p>');
					else {
						$result = delete_dbPersons($id);
						echo("<p>You have successfully removed " .$first_name." ".$last_name. " from the database.</p>");
					}
				}
				else {
					$result = delete_dbPersons($id);
					echo("<p>You have successfully removed " .$first_name." ".$last_name. " from the database.</p>");		
				}
			}
		}

		// try to reset the person's password
		else if($_POST['reset_pass']=="RESET"){
				$id = $_POST['old_id'];
				$result = delete_dbPersons($id);
				$newperson->set_password (md5($first_name . $clean_phone1));
                $result = insert_dbPersons($newperson);
				if (!$result)
                   echo ('<p class="error">Unable to reset ' .$first_name.' '.$last_name. "'s password.. <br>Please report this error to the Program manager.");
				else echo("<p>You have successfully reset " .$first_name." ".$last_name. "'s password.</p>");
		}

		// try to add a new person to the database
		else if ($_POST['old_id']=='new') {
			    $id = $first_name.$clean_phone1;
				//check if there's already an entry
				$dup = retrieve_dbPersons($id);
				if ($dup)
					echo('<p class="error">Unable to add ' .$first_name.' '.$last_name. ' to the database. <br>Another person with the same id is already there.');
				else {
					$newperson->set_password (md5($first_name.$clean_phone1));
					$result = insert_dbPersons($newperson);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$first_name.' '.$last_name. '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added " .$first_name." ".$last_name. " to the database.</p>");
				}
		}

		// try to replace an existing person in the database by removing and adding
		else {
				$id = $_POST['old_id'];
				$result = delete_dbPersons($id);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$first_name.' '.$last_name. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbPersons($newperson);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$first_name.' '.$last_name. '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated " .$first_name." ".$last_name. " in the database.</p>");
//					add_log_entry('<a href=\"viewPerson.php?id='.$id.'\">'.$first_name.' '.$last_name.'</a>\'s database entry has been updated.');
				}
		}
}
?>
    </div>
    <?PHP include('footer.inc');?>		
  </div>
</body>
</html>
