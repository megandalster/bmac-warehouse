<?PHP
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
/**
 *	contributionEdit.php
 *  oversees the editing of a person to be added, changed, or deleted from the database
 *	@author Luis Martin Munguia Orta
 *	@version March 10, 2015
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbfundingSources.php');
    include_once('database/dbContributions.php');
    include_once('domain/Contribution.php'); 
    include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 

//    include_once('database/dbLog.php');
	date_default_timezone_set('America/Los_Angeles');
	$id = $_GET["id"];
	if ($id=='new') {
	 	$contribution = new Contribution('new',date('y-m-d:h:i'),null,null,null,null);
	}
	else {
		$contribution = retrieve_dbContributions($id);
		if (!$contribution) {
	         echo('<p id="error">Error: there\'s no unique receipt in the database with this timestamp</p>'. $id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			<?PHP echo('Editing Receipt '.$contribution->get_receive_date());?>
		</title>
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
<script>
$(function() {
	$(document).on("keyup", ".product-id", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'GET',
			url: 'advanced_getProducts.php?q='+str
		})
		 .done(function (response) {
			//console.log(response)
			var suggestions = $.parseJSON(response);
			//console.log(suggestions);
			target.autocomplete({
				source: suggestions	
			});
		});
	});

	$(document).on("keyup", ".provider-id", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'GET',
			url: 'advanced_getProviders.php?q='+str
		})
		 .done(function (response) {
			//console.log(response)
			var suggestions = $.parseJSON(response);
			//console.log(suggestions);
			target.autocomplete({
				source: suggestions	
			});
		});
	});
	

	$("#add-more").on('click', function(e) {
		e.preventDefault();
		var new_row = '<br class=ui-widget>'
	    	+ '<input type="text" name="product-id[]" class="product-id" tabindex=1 size=20>&nbsp;&nbsp;&nbsp;&nbsp;'
		 	+ '<input type="text" name="product-unit-wt[]" class="product-unit-wt" tabindex=2 size=6>&nbsp;&nbsp;&nbsp;&nbsp;'
	    	+ '<input type="text" name="product-units[]" class="product-units" tabindex=3 size=6>&nbsp;&nbsp;&nbsp;&nbsp;'
			+ '<input type="text" name="product-total-wt[]" class="product-total-wt" tabindex=4 size=6>'
		$("#product-rows").append(new_row);
	});
	$( "#date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
});
</script>
		
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
		$receive_date = $_POST['date'].substr($contribution->get_receive_date(),8);
		$receive_items = gather_receive_items($_POST['product-id'],$_POST['product-unit-wt'],$_POST['product-units'],$_POST['product-total-wt']);
		$provider_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['provider-id']))));
		$billed_amt = trim(str_replace('\\\'','\'',htmlentities($_POST['billed_amt'])));
		$payment_source = $_POST['payment_source'];
		$notes = trim(str_replace('\\\'','\'',htmlentities($_POST['notes'])));
		$contribution = new Contribution($provider_id, $receive_date, $receive_items, $payment_source, $billed_amt, $notes);
		$errors = validate_form($contribution); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('contributionForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($contribution);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
function gather_receive_items($ids, $unit_wts, $units, $wts) {
	$receive_items = ""; 
	for ($i=0;$i<count($ids);$i++) 
	    if ($ids[$i]!="") {
	    	if ($unit_wts[$i]!="")
	    	    $receive_items .= ",".$ids[$i].";".$unit_wts[$i].":".$units[$i].":".$wts[$i];
		    else 
		    	$receive_items .= ",".$ids[$i].":".$units[$i].":".$wts[$i];
	    }
	return substr($receive_items,1);
}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($contribution)	{
		//try to make the deletion
		if($_POST['submit']=='delete' && $_POST['delete-check']=='delete') {
			$result = retrieve_dbContributions($contribution->get_receive_date());
			if (!$result)
				echo('<p>Unable to delete. Receipt with timestamp ' . $contribution->get_receive_date() .' is not in the database.');
			else {
				$result = delete_dbContributions($contribution->get_receive_date());
				echo("<p>You have successfully removed the receipt with timestamp " .$contribution->get_receive_date(). " from the database.</p>");	
			}
		}

		// try to add a new contribution (receipt) to the database
		else if ($_POST['old_id']=='new') {
			    //check if there's already an entry
				$dup = retrieve_dbContributions($contribution->get_receive_date());
				if ($dup)
					echo('<p class="error">Unable to add receipt with timestamp' .$contribution->get_receive_date(). ' to the database. <br>Another receipt with the same timestamp is already there.');
				else {
					$result = insert_dbContributions($contribution);
					if (!$result)
                        echo ('<p class="error">Unable to add the contribution from "' .$contribution->get_provider_id(). '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added a contribution from " .$contribution->get_provider_id(). " with timestamp <a href='contributionEdit.php?id=".
								$contribution->get_receive_date(). "'>".$contribution->get_receive_date()."</a> in the database.</p>");
				}
		}

		// try to replace an existing receipt in the database by removing and adding
		else {
				$result = delete_dbContributions($_POST['old_id']);
                if (!$result)
                   echo ('<p class="error">Unable to update receipt with timestamp ' .$_POST['old_id']. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbContributions($contribution);
                	if (!$result)
                   		echo ('<p class="error">Unable to update contribution with timestamp ' .$contribution->get_receive_date(). '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated the contribution from " .$contribution->get_provider_id(). " with timestamp <a href='contributionEdit.php?id=".
								$contribution->get_receive_date(). "'>".$contribution->get_receive_date()."</a> in the database.</p>");
//					add_log_entry('<a href=\"viewContribution.php?id='.$provider_id.'\">'.'</a>\'s database entry has been updated.');
				}
		}
}

function validate_form($id){
	if($id=='new' && $_POST['provider-id']==null || $_POST['provider-id']=='new'
					 || $_POST['provider-id']=='') $errors[] = 'Please enter the name of the provider';
	if (!valid_date($_POST['date'])) $errors[] = 'Please enter a valid receipt date';
	if($_POST['product-id']==null) $errors[] = 'Please enter one or more received';
	if($_POST['payment_source']==null) $errors[] = 'Please enter the payment source';
	return $errors;
}
function valid_date($date)
{
    $d = DateTime::createFromFormat('y-m-d', $date);
    return $d && $d->format('y-m-d') == $date;
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
