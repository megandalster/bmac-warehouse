<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
 * This program is part of RMH Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
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
	<strong>Editing and Adding a New Provider</strong>
<p>Note that editing information in the provider database can only be done by manager accounts.
<p>
	<strong>Step 1:</strong> First you must navigate to the <strong>providers</strong> search page.
	<BR> <BR> <a
		href="tutorial/screenshots/editproviderstep1.png" class="image"
		title="editproviderstep1.png"
		target="tutorial/screenshots/editproviderstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editproviderstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editproviderstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 2:</strong> To edit an existing provider use the search function and then click on
	the provider's name. To add a new provider click on <strong>Add new provider</strong>.
	You will now see a page with all of the provider's information, like this:
	<BR> <BR> <a
		href="tutorial/screenshots/editproviderstep2.png" class="image"
		title="editproviderstep2.png"
		target="tutorial/screenshots/editproviderstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editproviderstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editproviderstep2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=bmac-warehouse/providerSearch.php">click here</a>.
</p>
<p>
	<strong>Step 3:</strong> To change any of the provider's information,
	just retype or reselect it. For instance, to change a provider's status click on the status
	drop down menu and select their new status. <BR>&nbsp&nbsp REMEMBER: No fields marked by <font
	color="#FF0000">*</font> can be left blank. If creating a new provider, status defaults to 
	active and type to food.
</p>

<p>
	<strong>Step 4:</strong> When you finish making changes, select <strong>submit</strong>
	at the bottom of the page. If you wish to delete a provider, check the box and click on <strong>delete</strong>:
	<BR> <BR> <a
		href="tutorial/screenshots/editproviderstep4.png" class="image"
		title="editproviderstep4.png"
		target="tutorial/screenshots/editproviderstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editproviderstep4.png" rel="popover"
		data-img="tutorial/screenshots/editproviderstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/editproviderstep5.png" class="image"
		title="editproviderstep5.png"
		target="tutorial/screenshots/editproviderstep5.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editproviderstep5.png" width="10%"
		border="1px" rel="popover"
		data-img="tutorial/screenshots/editproviderstep5.png" align="middle"> </a>
	<BR>&nbsp&nbsp&nbsp *After you have make these corrections, repeat <B>Step
		4</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/editproviderstep6.png" class="image"
		title="editproviderstep6.png"
		target="tutorial/screenshots/editproviderstep6.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editproviderstep6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editproviderstep6.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.