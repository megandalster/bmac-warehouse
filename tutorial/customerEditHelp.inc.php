<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is 
 * free software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
?>

<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
	src="lib/bootstrap/js/bootstrap.js"></script>

<script>
	$(function () {
		$('img[rel=popover]').popover({
			  html: true,
			  trigger: 'hover',
			  placement: 'right',
			  content: function(){return '<img border="3" src="'+$(this).data('img') + '" width="60%"/>';}
			});
	});
</script>

<p>
	<strong>Editing, Deleting and Adding a New Customer</strong>
<p><b>Editing</b> a customer's information in the database is a simple process. Here are the steps:<p>
	<strong>Step 1:</strong> First you need to <strong>search</strong> for
	the customer whose information you want to edit. <BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep1.png" class="image"
		title="searchcustomerstep1.png"
		target="tutorial/screenshots/searchcustomerstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=bmac-warehouse/customerSearch.php">click here</a>.
</p>

<p>
	<strong>Step 2:</strong> After finding that customer, <strong> click on </strong>
	his/her name. You will now see a page with all of the customer's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep2.png" class="image"
		title="editcustomerstep2.png"
		target="tutorial/screenshots/editcustomerstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editcustomerstep2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 3:</strong> To change any of the customer's information,
	just retype or reselect it. For instance, to change the address, click on the 
	"Address" box, select what it written press delete to erase it. Then type the new
	 address. REMEMBER: No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>

<p>
	<strong>Step 4:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page:<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep4.png" class="image"
		title="editcustomerstep4.png"
		target="tutorial/screenshots/editcustomerstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep4.png" rel="popover"
		data-img="tutorial/screenshots/editcustomerstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep5.png" class="image"
		title="editcustomerstep5.png"
		target="tutorial/screenshots/editcustomerstep5.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep5.png" width="10%"
		border="1px" rel="popover"
		data-img="tutorial/screenshots/editcustomerstep5.png" align="middle"> </a>
	<BR> *After you have make these corrections, repeat <B>Step
		4</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep6.png" class="image"
		title="editcustomerstep6.png"
		target="tutorial/screenshots/editcustomerstep6.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editcustomerstep6.png"
		border="1px" align="middle"> </a>
		
		<BR>&nbsp&nbsp&nbsp You can go back to the same customer you just edited by clicking on the customer name
		like this:
		<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep7.png" class="image"
		title="editcustomerstep7.png"
		target="tutorial/screenshots/editcustomerstep7.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep7.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editcustomerstep7.png"
		border="1px" align="middle"> </a>
		
<p>
	<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
	

<p><b>Deleting a customer</b> from the database is a simple process. Here are the steps:<p>	
	<strong>Step 1:</strong> First you need to <strong>search</strong> for
	the customer whose information you want to delete. <BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep1.png" class="image"
		title="searchcustomerstep1.png"
		target="tutorial/screenshots/searchcustomerstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=bmac-warehouse/customerSearch.php">click here</a>.
</p>

<p>
	<strong>Step 2:</strong> After finding that customer, <strong> click on </strong>
	his/her name. You will now see a page with all of the customer's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/editcustomerstep2.png" class="image"
		title="editcustomerstep2.png"
		target="tutorial/screenshots/editcustomerstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editcustomerstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editcustomerstep2.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<strong>Step 3:</strong> To delete the customer check the box at the bottom of the page and hit <strong>Delete</strong>:<BR> <BR> <a
		href="tutorial/screenshots/deletecustomerstep3.png" class="image"
		title="deletecustomerstep3.png"
		target="tutorial/screenshots/deletecustomerstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/deletecustomerstep3.png" rel="popover"
		data-img="tutorial/screenshots/deletecustomerstep3.png" width="10%"
		border="1px" align="middle"> </a>
</p>
	
	
<p>
	<strong>Step 4:</strong> When you are done you will see a page telling you that the customer 
	has been removed from the database:<BR> <BR> <a
		href="tutorial/screenshots/deletecustomerstep4.png" class="image"
		title="deletecustomerstep4.png"
		target="tutorial/screenshots/deletecustomerstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/deletecustomerstep4.png" rel="popover"
		data-img="tutorial/screenshots/deletecustomerstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>	

<p>
	<B>Step 5:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.

<p><b>Adding a new customer</b> to the database is a simple process. Here are the steps:<p>	
	
	
<p>
<strong>Step 1:</strong> First you need to select the customer tab from the navigation bar <BR> <BR> <a
		href="tutorial/screenshots/searchcustomerstep1.png" class="image"
		title="searchcustomerstep1.png"
		target="tutorial/screenshots/searchcustomerstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchcustomerstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchcustomerstep1.png"
		border="1px" align="middle"> </a>
</p>


<p>
	<strong>Step 2:</strong> Select "Add new customer":<BR> <BR> <a
		href="tutorial/screenshots/addnewcustomerstep2.png" class="image"
		title="addnewcustomerstep2.png"
		target="tutorial/screenshots/addnewcustomerstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addnewcustomerstep2.png" rel="popover"
		data-img="tutorial/screenshots/addnewcustomerstep2.png" width="10%"
		border="1px" align="middle"> </a>
</p>	


<p>
	<strong>Step 3:</strong> Now you can add the new customer information. REMEMBER: No fields marked by <font
		color="#FF0000">*</font> can be left blank. :<BR> <BR> <a
		href="tutorial/screenshots/addnewcustomerstep3.png" class="image"
		title="addnewcustomerstep3.png"
		target="tutorial/screenshots/addnewcustomerstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addnewcustomerstep3.png" rel="popover"
		data-img="tutorial/screenshots/addnewcustomerstep3.png" width="10%"
		border="1px" align="middle"> </a>
</p>	

<p>
	<strong>Step 4:</strong> After you add the new customer information, click submit:<BR> <BR> <a
		href="tutorial/screenshots/addnewcustomerstep4.png" class="image"
		title="addnewcustomerstep4.png"
		target="tutorial/screenshots/addnewcustomerstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addnewcustomerstep4.png" rel="popover"
		data-img="tutorial/screenshots/addnewcustomerstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>	


<p>
	<strong>Step 5:</strong> If you added a customer with an existing customer ID in the database, you will see the screen below. To
	Fix the issue you will need to go back and change the customer ID.<BR> <BR> <a
		href="tutorial/screenshots/addnewcustomerstep5.png" class="image"
		title="addnewcustomerstep5.png"
		target="tutorial/screenshots/addnewcustomerstep5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addnewcustomerstep5.png" rel="popover"
		data-img="tutorial/screenshots/addnewcustomerstep5.png" width="10%"
		border="1px" align="middle"> </a>
</p>	


<p>
	<strong>Step 6:</strong> If the new customer is added successfully, you will see the screen below:<BR> <BR> <a
		href="tutorial/screenshots/addnewcustomerstep6.png" class="image"
		title="addnewcustomerstep6.png"
		target="tutorial/screenshots/addnewcustomerstep6.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addnewcustomerstep6.png" rel="popover"
		data-img="tutorial/screenshots/addnewcustomerstep6.png" width="10%"
		border="1px" align="middle"> </a>
</p>	

<p>
<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
</p>
