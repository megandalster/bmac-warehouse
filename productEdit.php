<?PHP
/*
 * Copyright 2014 by Allen Tucker. 
 * This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

/*
 *	productEdit.php
 *  oversees the editing of a product to be added, changed, or deleted from the database
 *	@author Allen Tucker
 *	@version December 29, 2014
 */
	session_start();
	session_cache_expire(30);
    include_once('database/dbProducts.php');
    include_once('domain/Product.php'); 
    
//    include_once('database/dbLog.php');
	$id = $_GET["id"];
	if ($id=='new') {
	 	$product = new product("new", null, null, null, null, null, null, null, 
    				null, null, null, null, null);
	}
	else {
		$product = retrieveWithFunding_dbProducts(substr($id, 1+strpos($id, " ")),substr($id, 0, strpos($id, " ")));
		if (!$product) {
	         echo('<p id="error">Error: there\'s no product with this id in the database</p>'. $id);
		     die();
        }  
	}
?>
<html>
	<head>
		<title>
			Editing <?PHP echo($product->get_funding_source()." ".$product->get_product_id());?>
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
		<script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
		<script>
		$(function() {
			$( "#inventory_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
			$( "#initial_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
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
			include('productForm.inc');
	}
	else {
	//in this case, the form has been submitted, so validate it
		if ($id=='new') {
				$product_id = trim($_POST['product_id']);
				$product_code = null;
		}
		else {
				$funding_source = $product->get_funding_source();
				$product_id = $product->get_product_id();
				$unit_weight = $product->get_unit_weight();
		}
		$product = new Product($product_id, $_POST['product_code'], $_POST['funding_source'], $_post['unit_weight'], $_POST['unit_price'], $_POST['initial_date'], $_POST['initial_stock'],
								 $_POST['minimum_stock'], $_POST['history'], $_POST['current_stock'], $_POST['status'], $_POST['inventory_date'], $_POST['notes']);
		$errors = validate_form($id); 	//step one is validation.
        // errors array lists problems on the form submitted
		if ($errors) {
		// display the errors and the form to fix
			show_errors($errors);
			include('productForm.inc');
		}
		// this was a successful form submission; update the database and exit
		else
			process_form($id, $product);
		include('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
	
/**
* process_form sanitizes data, concatenates needed data, and enters it all into a database
*/
function process_form($id, $product)	{
	//step one: sanitize data by replacing HTML entities and escaping the ' character
		if ($id=='new') {
			    $product_id = trim(str_replace('\\\'','',htmlentities(trim($_POST['product_id']))));
			    //$product_id = $_POST['product_id'];
			    $unit_weight = $_POST['unit_weight'];
			    $funding_source = $_POST['funding_source'];
				$product_code = null;

		}
		else {
				$product_id = $product->get_product_id();
				$product_code = $product->get_product_code();
				$funding_source = $product->get_funding_source();
				$unit_weight = $product->get_unit_weight();
		}
		
		$unit_price = trim(htmlentities($_POST['unit_price']));
		$initial_date = trim(htmlentities($_POST['initial_date']));
		$initial_stock = trim(htmlentities($_POST['initial_stock']));
		$minimum_stock = trim(htmlentities($_POST['minimum_stock']));
		$current_stock = trim(htmlentities($_POST['current_stock']));	
		$inventory_date = trim(htmlentities($_POST['inventory_date']));				
        $status = $_POST['status'];
        $notes = trim(str_replace('\\\'','\'',htmlentities($_POST['my_notes'])));
		
		$newproduct = new Product($product_id, $product_code, $funding_source, $unit_weight, $unit_price, $initial_date, $initial_stock, $minimum_stock, null, $current_stock,
                         $inventory_date, $status, $notes);
        
	//step two: try to make the deletion, addition, or change
		if($_POST['submit']=="delete" && $_POST['delete-check']=='delete'){
			$result = retrieve_dbProducts($product_id);
			if (!$result)
				echo('<p>Unable to delete. ' .$product_id. ' is not in the database.');
			else {
				$result = delete_dbProducts($product_id);
				echo("<p>You have successfully removed " .$product_id. " from the database.</p>");		
			}
		}

		// try to add a new product to the database
		else if($_POST['submit']=='submit' && $_POST['old_id']=='new') {
			    //$id = $first_name.$clean_phone1;
				//check if there's already an entry
				$dup = retrieve_dbProducts($product_id);
				if ($dup)
					echo('<p class="error">Unable to add ' .$product_id. ' to the database. <br>Another product with the same id is already there.');
				else {
					$result = insert_dbProducts($newproduct);
					if (!$result)
                        echo ('<p class="error">Unable to add "' .$product_id. '" to the database. <br>Please report this error to the Program manager.');
					else echo("<p>You have successfully added " .$product_id. " to the database.</p>");
				}
		}

		// try to replace an existing product in the database by removing and adding
		else if($_POST['submit']=='submit') {
				$result = delete_dbProducts($product_id);
                if (!$result)
                   echo ('<p class="error">Unable to update ' .$product_id. '. <br>Please report this error to the Program manager.');
				else {
					$result = insert_dbProducts($newproduct);
                	if (!$result)
                   		echo ('<p class="error">Unable to update ' .$product_id. '. <br>Please report this error to the Foodbank Director.');
					else echo("<p>You have successfully updated " .$product_id. " in the database.</p>");
//					add_log_entry('<a href=\"viewProduct.php?id='.$product_id.'\">'.$product_id.'</a>\'s database entry has been updated.');
				}
		}
}
/*
 * 
 * 
 */
function validate_form($id){
	if($id=='new' && ($_POST['product_id']==null || $_POST['product_id']=='new')) $errors[] = 'Please enter a product name';
	//if($_POST['unit_weight']==null) $errors[] = 'Please enter a unit weight';
	//if(is_numeric($_POST['unit_weight'])==FALSE) $errors[] = 'Unit weight must be a number.';
	/*
	if($_POST['city']==null) $errors[] = 'Please enter a city';
	if($_POST['address']==null) $errors[] = 'Please enter an address';
	if($_POST['state']==null) $errors[] = 'Please enter a state';
	if(($_POST['zip'] != strval(intval($_POST['zip']))) || ($_POST['zip']==null) || (strlen($_POST['zip'])!=5)) $errors[] = 'Please enter a valid zip code';
	if($_POST['type']==null && $_SESSION['access_level']>=1) $errors[] = 'Please select a Type';

	if($_POST['phone2']!=null && !valid_phone($_POST['phone2'])) $errors[] = 'Please enter a valid secondary phone number (10 digits: ###-###-####)';
	if(!valid_email($_POST['email']) && $_POST['email']!=null) $errors[] = "Please enter a valid email";
	*/
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
