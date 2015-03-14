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
        
	//step two: try to make the deletion, addition, or change
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
/*
 * 
 * 
 */
function validate_form($id){
	if($id=='new' && ($_POST['first_name']==null || $_POST['first_name']=='new')) $errors[] = 'Please enter a first name';
	if($id=='new' && $_POST['last_name']==null) $errors[] = 'Please enter a last name';
	if($id=='new' && !valid_phone($_POST['phone1'])) $errors[] = 'Please enter a valid primary phone number (10 digits: ###-###-####)';
	if($_POST['city']==null) $errors[] = 'Please enter a city';
	if($_POST['address']==null) $errors[] = 'Please enter an address';
	if($_POST['state']==null) $errors[] = 'Please enter a state';
	if(($_POST['zip'] != strval(intval($_POST['zip']))) || ($_POST['zip']==null) || (strlen($_POST['zip'])!=5)) $errors[] = 'Please enter a valid zip code';
	if($_POST['type']==null && $_SESSION['access_level']>=1) $errors[] = 'Please select a Type';
	if ($_SESSION['access_level']<3 && $_POST['type']=='manager')
		$errors[] = "Sorry, you can't promote yourself to a mamager.";
	if($_POST['phone2']!=null && !valid_phone($_POST['phone2'])) $errors[] = 'Please enter a valid secondary phone number (10 digits: ###-###-####)';
	if(!valid_email($_POST['email']) && $_POST['email']!=null) $errors[] = "Please enter a valid email";
	return $errors;
}
/**
* valid_phone validates a phone on the following parameters:
* 		it assumes the characters '-' ' ' '+' '(' and ')' are valid, but ignores them
*		every other digit must be a number
*		it should be between 7 and 11 digits
* returns boolean if phone is valid
*/
function valid_phone($phone){
		if($phone==null) return false;
		$phone = str_replace(' ','',str_replace('+','',str_replace('(','',str_replace(')','',str_replace('-','',$phone)))));
		$test = str_replace('0','',str_replace('1','',str_replace('2','',str_replace('3','',str_replace('4','',str_replace('5','',str_replace('6','',str_replace('7','',str_replace('8','',str_replace('9','',$phone))))))))));
		if($test != null) return false;
		if ( (strlen($phone)) != 10) return false;
		return true;
}

//Function from <http://www.phpit.net/code/valid-email/>
function valid_email($email) {
		// First, we check that there's one @ symbol, and that the lengths are right
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
				return false;
			}
		}
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
}

function show_errors($e){
		//this function should display all of our errors.
		echo('<div class="warning">');
		echo('<ul>');
		foreach($e as $error){
			echo("<li><strong><font color=\"red\">".$error."</font></strong></li>\n");
		}
		echo("</ul></div></p>");
}
?>
    </div>
    <?PHP include('footer.inc');?>		
  </div>
</body>
</html>
