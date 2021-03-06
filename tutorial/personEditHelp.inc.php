<?php
/*
 * Copyright 2014 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
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
	<strong>Adding and Editing Staff Records</strong>
<p>Editing staff login and contact information in the database is done by the 
Foodbank Director. He can add new staff logins for anyone needing to access the system. 
That person will have the type "office", "warehouse", or "manager" depending on the
level of access needed.
<p>
	<strong>Step 1:</strong> To <strong>search</strong> for
	a staff member whose information you want to edit, select <b>staff</b> in the
	top menu bar and then hit Search on the page that appears, like this: <BR> <BR> <a
		href="tutorial/screenshots/editpersonstep1.png" class="image"
		title="editpersonstep1.png"
		target="tutorial/screenshots/editpersonstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep1.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<strong>Step 2:</strong> After finding that person in the list that appears, <strong> click on </strong>
	his/her name. You will now see a page with all of the person's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep2.png" class="image"
		title="editpersonstep2.png"
		target="tutorial/screenshots/editpersonstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 3:</strong> To change any of this information,
	just retype or reselect it. <BR>&nbsp&nbsp REMEMBER: No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>

<p>
	<strong>Step 4:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep4.png" class="image"
		title="editpersonstep4.png"
		target="tutorial/screenshots/editpersonstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep4.png" rel="popover"
		data-img="tutorial/screenshots/editpersonstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct.  After you have make these corrections, repeat <B>Step
		4</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep6.png" class="image"
		title="editpersonstep6.png"
		target="tutorial/screenshots/editpersonstep6.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep6.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 7:</B> On the page shown in <b>Step 4</b>, notice that you can also reset a
	person's password to default, or even completely remove a person from the
	database if he/she is no longer authorized to access this system.
<p>
	<B>Step 8:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
<p>
	<B>Note:</B> You can also add a new person to the database by selecting 
	"Add New Staff" in the display shown in <b>Step 1</b>. This will give you a blank form
	that looks like this:
	<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep7.png" class="image"
		title="editpersonstep7.png"
		target="tutorial/screenshots/editpersonstep7.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep7.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep7.png"
		border="1px" align="middle"> </a>
	<br><br>
	After filling in the person's contact information and selecting his/her type,
	select "Submit" at the bottom of the page.  This will create a now login
	for that person with the default password.  When that person logs in for
	the first time, he/she may change that password to something more secure.
