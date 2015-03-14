<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

//Use St.Vincent/Clarkson from 14-12-03:13:51

/**
 *	shipmentEdit.php
 *  oversees the editing of a person to be added, changed, or deleted from the database
 *	@author Dylan Martin
 *	@version March 13, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbShipments.php');
    include_once('domain/Shipment.php'); 
    
//    include_once('database/dbLog.php');
	$ship_date = $_GET["id"];
	if ($ship_date=='new') {
	 	$shipment = new Shipment(null, null, 'new', null, null, 
	 	null, null, null, null, null, null);
	}
	
	else {
		$shipment = retrieve_dbShipmentsDate($ship_date);
		if (!$shipment) {
	         echo('<p id="error">Error: there\'s no shipment from this date in the database</p>'. $ship_date);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($shipment->get_ship_date());?>
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
			include('shipmentForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
		if ($ship_date=='new') {
				$ship_date = trim($_POST['ship_date']);
				$customer_id = null;
		}
		else {
				$ship_date = $shipment->get_ship_date();
				$customer_id = $shipment->get_customer_id();
		}
		$shipment = new Shipment($customer_id, $_POST['funds_source'], $ship_date, 
								 $_POST['ship_via'], $_POST['ship_items'], $_POST['ship_rate'],
								 $_POST['total_weight'], $_POST['total_price'], $_POST['invoice_date'], 
								 $_POST['invoice_no'], $_POST['notes']);
		$errors = validate_form($ship_date); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('shipmentForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($ship_date, $shipment);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($ship_date, $shipment)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($ship_date=='new') {
				$ship_date = trim($_POST['ship_date']);
		}
		else {
				$ship_date = $shipment->get_ship_date();
				//$customer_id = $shipment->get_customer_id();
		}
		
		
	 	$customer_id = trim(htmlentities($_POST['customer_id']));
		$funds_source = trim(htmlentities($_POST['funds_source']));
		$ship_date = $_POST['ship_date'];
		$ship_via = trim(htmlentities($_POST['ship_via']));
		$ship_items = trim(htmlentities($_POST['ship_items']));
		$ship_rate = trim(htmlentities($_POST['ship_rate']));
		$total_weight = trim(htmlentities($_POST['total_weight']));
		$total_price = trim(htmlentities($_POST['total_price']));			
        $invoice_date = trim(htmlentities($_POST['invoice_date']));
        $notes = trim(str_replace('\\\'','\'',htmlentities($_POST['my_notes'])));
		$invoice_number = trim(htmlentities($_POST['invoice_number']));
		
		
		$newshipment = new Shipment($customer_id, $funds_source, $ship_date, $ship_via, $ship_items, $ship_rate, 
									$total_weight, $total_price, $invoice_date, $invoice_no, $notes);
        
	//step two: try to make the deletion, addition, or change
		if($_POST['submit']=='delete' && $_POST['delete-check']=='delete') {
			$result = retrieve_dbShipmentsDate($ship_date);
			if (!$result)
				echo('<p>Unable to delete. ' .$customer_id. ' is not in the database. <br>Please report this error to the House Manager.');
			else {
					$result = delete_dbShipmentsDate($ship_date);
					echo("<p>You have successfully removed " .$customer_id. " from the database.</p>");		
				}
			}
		

		// try to add a new shipment to the database
		else if($_POST['submit']=='submit' && $_POST['old_id']=='new') {
				//check if there's already an entry
				$dup = retrieve_dbShipmentsDate($ship_date);
				if ($dup)
					echo('<p class="error">Unable to add ' .$customer_id. ' to the database. <br>Another shipment with the same id is already there.');
				else {
					$result = insert_dbShipments($newshipment);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$customer_id. '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added " .$customer_id. " to the database.</p>");
				}
					
		}

		// try to replace an existing person in the database by removing and adding
		else if($_POST['submit']=='submit') {
				$result = delete_dbShipmentsDate($ship_date);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$customer_id. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbShipments($newshipment);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$customer_id. '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated " .$customer_id. " in the database.</p>");
//					add_log_entry('<a href=\"viewPerson.php?id='.$id.'\">'.$first_name.' '.$last_name.'</a>\'s database entry has been updated.');
				}
		}
}
/*
 * 
 * 
 */

function validate_form($ship_date){
	/*
	if($ship_date=='new' && ($_POST['customer_id']==null || $_POST['customer_id']=='new')) $errors[] = 'Please enter a customer';
	if($ship_date=='new' && $_POST['last_name']==null) $errors[] = 'Please enter a last name';
	if($ship_date=='new' && !valid_phone($_POST['phone1'])) $errors[] = 'Please enter a valid primary phone number (10 digits: ###-###-####)';
	if($_POST['city']==null) $errors[] = 'Please enter a city';
	if($_POST['address']==null) $errors[] = 'Please enter an address';
	if($_POST['ship_via']==null) $errors[] = 'Please enter a state';
	if(($_POST['zip'] != strval(intval($_POST['zip']))) || ($_POST['zip']==null) || (strlen($_POST['zip'])!=5)) $errors[] = 'Please enter a valid zip code';
	if($_POST['type']==null && $_SESSION['access_level']>=1) $errors[] = 'Please select a Type';
	if ($_SESSION['access_level']<3 && $_POST['type']=='manager')
		$errors[] = "Sorry, you can't promote yourself to a mamager.";
	if($_POST['phone2']!=null && !valid_phone($_POST['phone2'])) $errors[] = 'Please enter a valid secondary phone number (10 digits: ###-###-####)';
	if(!valid_email($_POST['email']) && $_POST['email']!=null) $errors[] = "Please enter a valid email";
	return $errors;
	*/
}

/**
* valid_phone validates a phone on the following parameters:
* 		it assumes the characters '-' ' ' '+' '(' and ')' are valid, but ignores them
*		every other digit must be a number
*		it should be between 7 and 11 digits
* returns boolean if phone is valid
*/

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
