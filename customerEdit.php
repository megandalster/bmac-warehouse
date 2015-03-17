<?PHP
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 *	customerEdit.php
 *  oversees the editing of a customer to be added, changed, or deleted from the database
 *	@author Moustafa ElBadry
 *	@version March 04, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbCustomers.php');
    include_once('domain/Customer.php'); 
    
//    include_once('database/dbLog.php');
	$customer_id = $_GET["id"];
	if ($customer_id=='new') {
	 	$customer = new Customer('new',null,null,null,null,null,null,null,null,null,null,null);
	}
	else {
		$customer = retrieve_dbCustomers($customer_id);
		if (!$customer) {
	         echo('<p customer_id="error">Error: there\'s no customer with this customer_id in the database</p>'. $customer_id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($customer->get_customer_id()." ".$customer->get_phone());?>
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
			include('customerForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
		
		if ($customer_id=='new') {
			    $customer_id = trim($_POST['customer_id']);
				$code = "";
		}
		else {
				$customer_id = $customer->get_customer_id();
				$code = $customer->get_code();
		}
		$customer = new Customer($customer_id, $code, $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip'],
								 $_POST['county'], $_POST['contact'],$_POST['phone'],
								 $_POST['email'], $_POST['status'], $_POST['notes']);
								 
		$errors = validate_form($customer_id); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('customerForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($customer_id, $customer);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($customer_id, $customer)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($customer_id=='new') {
			    $customer_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['customer_id']))));
				$code = "";
				$address = trim(str_replace(' ','',htmlentities($_POST['address'])));
				$clean_phone = preg_replace("/[^0-9]/", "", $phone);
		}
		else {
				$customer_id = $customer->get_customer_id();
				$code = $customer->get_code();
				$phone = $customer->get_phone();
				$clean_phone = $phone;
		}
		$address = trim(str_replace('\\\'','\'',htmlentities($_POST['address'])));
		$city = trim(str_replace('\\\'','\'',htmlentities($_POST['city'])));
		$state = trim(htmlentities($_POST['state']));
		$zip = trim(htmlentities($_POST['zip']));
		$county = trim(htmlentities($_POST['county']));
		$contact = trim(str_replace(' ','',htmlentities($_POST['contact'])));
		$clean_contact = preg_replace("/[^0-9]/", "", $contact);
	    $email = $_POST['email'];
	    $status = $_POST['status'];
        $notes =  trim(str_replace('\\\'','\'',htmlentities($_POST['notes'])));
		
		
		$newcustomer = new Customer($customer_id, $code, $address, $city, $state, $zip, 
						$county, $contact, $phone, $email, $status, $notes);
        
	//step two: try to make the deletion, addition, or change
		if($_POST['deleteMe']=="DELETE"){
			$result = retrieve_dbCustomers($customer_id);
			if (!$result)
				echo('<p>Unable to delete. ' .$customer_id. ' is not in the database. <br>Please report this error to the House Manager.');
			else {
					$result = delete_dbCustomers($customer_id);
					echo("<p>You have successfully removed " .$customer_id. " from the database.</p>");		
				}
		}

		// try to add a new customer to the database
		else if ($_POST['old_customer_id']=='new') {
			    //check if there's already an entry
				$dup = retrieve_dbCustomers($customer_id);
				if ($dup)
					echo('<p class="error">Unable to add ' .$customer_id.  ' to the database. <br>Another customer with the same id is already there.');
				else {
					    $result = insert_dbCustomers($newcustomer);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$customer_id.' " to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added <a href='customerEdit.php?id=" .$customer_id.  "'>"
					              .$customer_id."</a> to the database.</p>");
				}
		}

		// try to replace an existing customer in the database by removing and adding
		else {
				$result = delete_dbCustomers($customer_id);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$customer_id. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbCustomers($newcustomer);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$customer_id.  '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated <a href='customerEdit.php?id=" .$customer_id.  "'>"
					              .$customer_id."</a> in the database.</p>");
//					add_log_entry('<a href=\"viewCustomer.php?id='.$id.'\">'.$customer_id.' '.$phone.'</a>\'s database entry has been updated.');
				}
		}
}
/*
 * 
 * 
 */
function validate_form($customer_id){
	if($customer_id=='new' && ($_POST['customer_id']==null || $_POST['customer_id']=='new')) $errors[] = 'Please enter a Customer ID';
	if($customer_id=='new' && $_POST['code']==null) $errors[] = 'Please enter a Customer code';
	if($customer_id=='new' && !valid_phone($_POST['phone'])) $errors[] = 'Please enter a valid primary phone number (10 digits: ###-###-####)';
	if($_POST['city']==null) $errors[] = 'Please enter a city';
	if($_POST['address']==null) $errors[] = 'Please enter an address';
	if($_POST['state']==null) $errors[] = 'Please enter a state';
	if(($_POST['zip'] != strval(intval($_POST['zip']))) || ($_POST['zip']==null) || (strlen($_POST['zip'])<5)) $errors[] = 'Please enter a valid zip code';
	if($_POST['phone']!=null && !valid_phone($_POST['phone'])) $errors[] = 'Please enter a valid phone number (10 digits: ###-###-####)';
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
