<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
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
	<strong>Using the Inventory Worksheet</strong>
</p>
<p> Here you can view the products that the warehouse has currently in stock, their history, and you can also update their current stock.<br>
	You can also undo recent changes to products if the information you input was erroneous.
</p>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>Work on inventory for all active products with names that begin with:</B>
	and type in the search box the products you want to review, like this:<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep1.png" class="image"
		title="addpersonhelpstep1.png" horizontalalign="center"
		target="tutorial/screenshots/addpersonhelpstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep1.png"
		border="1px" align="center"> </a>
</p>
<p>
	<B>Step 2:</B> You should now see a long list of all products that begin with whatever you typed
		in the search box:<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep2.png" class="image"
		title="addpersonhelpstep2.png"
		target="tutorial/screenshots/addpersonhelpstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep2.png"
		border="1px" align="middle"> </a> <BR> You can scroll down to see the full list. <br>(NOTE:&nbsp All fields marked
		by <font color="#FF0000">*</font> are required before a person can be
	added to the database.)
</p>

<p>
	<B>Step 3:</B> There will be two boxes at the right of each product information, where you can edit their <B>Current Stock in case lots</B> and
	their <B>Current Stock in total weight</B> by typing them in the box.<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep3.png" class="image"
		title="addpersonhelpstep3.png"
		target="tutorial/screenshots/addpersonhelpstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep3.png"
		border="1px" align="middle"> </a>

</p>
<p>
	<B>Step 4:</B> If you leave either box blank, it will be automatically computed given the last inventory check of the product, plus its recent shipments and receipts, like so:<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep3.png" class="image"
		title="addpersonhelpstep3.png"
		target="tutorial/screenshots/addpersonhelpstep3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep3.png"
		border="1px" align="middle"> </a>
</p>
		
		
		
		
<p>
	<B>Step 4:</B> If you make a mistake or omit a required field, <font
		color=#FF0000>red</font> warnings will tell you what you need to
	correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep4.png" class="image"
		title="addpersonhelpstep4.png" horizontalalign="center"
		target="tutorial/screenshots/addpersonhelpstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep4.png"
		border="1px" align="middle"> </a> <br>After you make these
		corrections, repeat <B>Step 3</B>.
</p>
<p>
	<B>Step 5:</B> If you have no errors or omissions, you will see a page
	that looks like this:<BR> <BR> <a
		href="tutorial/screenshots/addpersonhelpstep5.png" class="image"
		title="addpersonhelpstep5.png" horizontalalign="center"
		target="tutorial/screenshots/addpersonhelpstep5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addpersonhelpstep5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/addpersonhelpstep5.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
</p>