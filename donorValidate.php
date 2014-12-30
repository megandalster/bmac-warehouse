<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen 
 * Tucker.  This program is part of Homerestore, which is free software.  It comes 
 * with absolutely no warranty.  You can redistribute and/or modify it under the 
 * terms of the GNU Public License as published by the Free Software Foundation 
 * (see <http://www.gnu.org/licenses/).
 */

/** 
 * Validates information provided for a donor
 * @author Jim Garvey 
 * @version October 20, 2013
 */

function validate_form($id){
    $errors = array();
	
    if(!$_POST['id'] || trim($_POST['id'])=="")    
    	$errors[] = 'Please enter a name';
	
	if($_POST['zip'] != null && strlen($_POST['zip'])!=5) 
		$errors[] = 'Please enter a valid zip code';
	
	if($_POST['phone1'] != null && !valid_phone($_POST['phone1'])) 
		$errors[] = 'Enter a valid contact phone number (7 or 10 digits)';
    
    if(!$errors)
        return "";
    else
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
		if (strlen($phone) != 7 && strlen($phone) != 10) return false;
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