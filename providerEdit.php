<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 *	providerEdit.php
 *  oversees the editing of a provider to be added, changed, or deleted from the database
 *	@author David Quennoz
 *	@version 3/3/2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbProviders.php');
    include_once('domain/Provider.php'); 
    
//    include_once('database/dbLog.php');
	$id = $_GET["id"];
	if ($id=='new') {
	 	$provider = new Provider('new', null, null, null, null, null, null, null, null, null,
	 	     	null, null, null);
	}
	else {
		$provider = retrieve_dbProviders($id);
		if (!$provider) {
	         echo('<p id="error">Error: there\'s no provider with this id in the database</p>'. $id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($provider->get_provider_id());?>
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
			include('providerForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
		if ($id=='new') {
				$provider_id = trim($_POST['provider_id']);
				$code = null;
		}
		else {
				$provider_id = $provider->get_provider_id();
				$code = $provider->get_code();
		}
		$provider = new Provider($provider_id, $code, $_POST['type'], $_POST['address'], 
								 $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['county'],
								 $_POST['contact'], $_POST['phone'], $_POST['email'], $_POST['status'], $_POST['notes']);
		$errors = validate_form($id); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('providerForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($id, $provider);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($id, $provider)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($id=='new') {
			    $provider_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['provider_id']))));
			    $code = null;
		}
		else {
				$provider_id = $provider->get_provider_id();
				$code = $provider->get_code();
		}
		$address = trim(str_replace('\\\'','\'',htmlentities($_POST['address'])));
		$city = trim(str_replace('\\\'','\'',htmlentities($_POST['city'])));
		$state = trim(htmlentities($_POST['state']));
		$zip = trim(htmlentities($_POST['zip']));
		$county = trim(str_replace('\\\'','\'',htmlentities($_POST['county'])));
		$contact = trim(str_replace('\\\'','\'',htmlentities($_POST['contact'])));
		$phone = trim(str_replace(' ','',htmlentities($_POST['phone'])));
		$clean_phone = preg_replace("/[^0-9]/", "", $phone);
		$email = $_POST['email'];
		$type = $_POST['type'];			
        $status = $_POST['status'];
        $notes = trim(str_replace('\\\'','\'',htmlentities($_POST['notes'])));
		
		$newprovider = new Provider($provider_id, $code, $type, $address, $city, $state, $zip, $county, $contact, 
						$clean_phone, $email, $status, $notes);
        
	//step two: try to make the deletion, addition, or change
		if($_POST['submit']=='delete' && $_POST['delete-check']=='delete') {
			$result = retrieve_dbProviders($provider_id);
			if (!$result)
				echo('<p>Unable to delete. ' . $provider_id . ' is not in the database.');
			else {
				$result = delete_dbProviders($provider_id);
				echo("<p>You have successfully removed " .$provider_id. " from the database.</p>");		
			}
		}

		// try to add a new provider to the database
		else if($_POST['submit']=='submit' && $_POST['old_id']=='new') {
				//check if there's already an entry
				$dup = retrieve_dbProviders($provider_id);
				if ($dup)
					echo('<p class="error">Unable to add ' .$provider_id. ' to the database. <br>Another provider with the same id is already there.');
				else {
					$result = insert_dbProviders($newprovider);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$provider_id. '" to the database. <br>Please report this error to the Program manager.');
					else 
					    echo('<p>You have successfully added <a href="providerEdit.php?id=' . $provider_id . '"><b>' . $provider_id . ' </b></a> to the database.</p>');
				}
		}

		// try to replace an existing person in the database by removing and adding
		else if($_POST['submit']=='submit') {
				$result = delete_dbProviders($provider_id);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$provider_id. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbProviders($newprovider);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$provider_id. '. <br>Please report this error to the Program manager.');
					else 
					    echo('<p>You have successfully updated <a href="providerEdit.php?id=' . $provider_id . '"><b>' . $provider_id . ' </b></a> in the database.</p>');
//					add_log_entry('<a href=\"viewProvider.php?id='.$provider_id.'\">'.$provider_id.'</a>\'s database entry has been updated.');
				}
		}
}



function validate_form($id) {
	//Check required fields
	if($id=='new' && ($_POST['provider_id']==null || $_POST['provider_id']=='new')) $errors[] = 'Please enter a provider name';
	if($_POST['status'] != 'active' && $_POST['status'] != 'inactive') $errors[] = 'Please select a status';
	if($_POST['type'] != 'funds' && $_POST['type'] != 'food') $errors[] = 'Please select a type';
	
	//Check validity of entered field where possible
	if($_POST['phone']!=null && !valid_phone($_POST['phone'])) $errors[] = 'Please enter a valid phone number (10 digits: ###-###-####)';
	if($_POST['email']!=null && !valid_email($_POST['email'])) $errors[] = "Please enter a valid email";
	if($_POST['zip']!=null && ($_POST['zip'] != strval(intval($_POST['zip'])) || strlen($_POST['zip'])!=5))  $errors[] = 'Please enter a valid zip code';
	
	if($_POST['submit']=='delete' && $_POST['delete-check']!='delete') $errors[] = 'You must check the box to verify deletion';

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
