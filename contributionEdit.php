<?PHP
/*
 * Copyright 2014 by Luis Martin Munguia Orta. 
 * This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/**
 *	ContributionEdit.php
 *  oversees the editing of a person to be added, changed, or deleted from the database
 *	@author Luis Martin Munguia Orta
 *	@version March 10, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 

//    include_once('database/dbLog.php');
	$id = $_GET["id"];
	if ($id=='new') {
	 	$contribution = new Contribution('new',null,null,null,null,null);
	}
	else {
		$contribution = retrieve_dbContributions($id);
		if (!$contribution) {
	         echo('<p id="error">Error: there\'s no receipt with this id in the database</p>'. $id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($contribution->get_provider_id());?>
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
			include('contributionForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
			if ($id=='new') {
				$provider_id = trim($_POST['provider_id']);
				$code = null;
		}
		else {
				$provider_id = $contribution->get_provider_id();
				
		}
		$contribution = new Contribution($provider_id, $_POST['receive_date'], $_POST['payment_source'], $_POST['billed_amt'], $_POST['notes']);
		$errors = validate_form($id); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('contributionForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($id, $contribution);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($id, $contribution)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($id=='new') {
			    $provider_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['provider_id']))));
				
		}
		else {
				$provider_id = $contribution->get_provider_id();
				
		}
		$receive_date = $_POST['receive_date'];
		$receive_items = $_POST['receive_items'];     
		$billed_amt = trim(str_replace('\\\'','\'',htmlentities($_POST['billed_amt'])));
		$notes = trim(str_replace('\\\'','\'',htmlentities($_POST['notes'])));
		
		$contribution = new Contribution($provider_id, $receive_date, $receive_items, $payment_source, $billed_amt, $notes);
        
	//step two: try to make the deletion, addition, or change
		if($_POST['submit']=='delete' && $_POST['delete-check']=='delete') {
			$result = retrieve_dbContributions($provider_id);
			if (!$result)
				echo('<p>Unable to delete. ' . $provider_id . ' is not in the database.');
			else {
				$result = delete_dbContributions($provider_id);
				echo("<p>You have successfully removed " .$provider_id. " from the database.</p>");	
			}
		}

		// try to add a new contribution (receipt) to the database
		else if ($_POST['old_id']=='new') {
			    //check if there's already an entry
				$dup = retrieve_dbContributions($provider_id);
				if ($dup)
					echo('<p class="error">Unable to add ' .$provider_id. ' to the database. <br>Another receipt with the same timestamp is already there.');
				else {
					$result = insert_dbContributions($contribution);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$provider_id. '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added " .$provider_id. " to the database.</p>");
				}
		}

		// try to replace an existing receipt in the database by removing and adding
		else {
				$provider_id = $_POST['old_id'];
				$result = delete_dbContributions($provider_id);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$provider_id. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbContributions($contribution);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$provider_id. '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated " .$provider_id. " in the database.</p>");
//					add_log_entry('<a href=\"viewContribution.php?id='.$provider_id.'\">'.'</a>\'s database entry has been updated.');
				}
		}
}

function validate_form($id){
	if($id=='new' && ($_POST['provider_id']==null || $_POST['provider_id']=='new')) $errors[] = 'Please enter the name of the provider';
	if($_POST['receive_items']==null) $errors[] = 'Please enter the items received';
	if($_POST['payment_source']==null) $errors[] = 'Please enter the payment source';
	if($_POST['billed_amt']==null) $errors[] = 'Please enter the amount billed';
	return $errors;
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

