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
<p> Here you can view the products that are currently in stock, update their current stock levels, and correct past recording errors. 
</p>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, hit <b>products</b> and then select <B>Work on inventory</b>. You should see a 
	page that looks like this:<BR> <BR><a
		href="tutorial/screenshots/inventoryHelp1.png" class="image"
		title="inventoryHelp1.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp1.png"
		border="1px" align="center"> </a>
	<BR> <BR>In the box labeled "Show all active products with names that begin with" type the first few letters of a group of products that you want to 
	inventory ("a" is there by default, and all the products that begin with a are listed by default). <BR> <BR> Note: You may need to scroll down to see the full list.  
</p>
<p>
	<B>Step 2:</B> For example, if you type "cheese" in that box and then hit "Update", you should see a list of all products that match what you typed, as shown below: <BR> <BR><a
		href="tutorial/screenshots/inventoryHelp2.png" class="image"
		title="inventoryHelp2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp2.png"
		border="1px" align="center"> </a>
</p>

<p>
	<B>Step 3:</B> Each product line shows its funding source, unit weight, data from when the last inventory was taken, and two boxes on the right where you
	can enter the current stock -- units (case lots) and/or total weight -- as shown in <b>a.</b> below.  When you hit "Update", the result will appear
	as shown in <b>b.</b> below.<BR> <BR> <b>a.</b><a
		href="tutorial/screenshots/inventoryHelp3.png" class="image"
		title="inventoryHelp3.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp3.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/inventoryHelp3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp3.png"
		border="1px" align="center"> </a>
		&nbsp;&nbsp;&nbsp;&nbsp;<b>b.</b><a
		href="tutorial/screenshots/inventoryHelp3-2.png" class="image"
		title="inventoryHelp3-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp3-2.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/inventoryHelp3-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp3-2.png"
		border="1px" align="center"> </a>

</p>
<p>
	<B>Step 4:</B> If you leave the total weight or units box blank, it will be automatically computed from the unit weight, as shown in <b>a.</b> and <b>b.</b> below:<BR> <BR> 
	    <b>a.</b><a
		href="tutorial/screenshots/inventoryHelp4.png" class="image"
		title="inventoryHelp4.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp4.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/inventoryHelp4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp4.png"
		border="1px" align="center"> </a>
		&nbsp;&nbsp;&nbsp;&nbsp; <b>b.</b><a
		href="tutorial/screenshots/inventoryHelp4-2.png" class="image"
		title="inventoryHelp4-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp4-2.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/inventoryHelp4-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp4-2.png"
		border="1px" align="center"> </a>

</p>	
		
<p>
	<B>Step 5:</B> If you make a mistake, you can always "undo" it by checking the <b>Undo</b> box for that product and then hitting Update, as shown in <b>a.</b> and <b>b.</b> below:<BR> <BR> 
	    <b>a.</b><a
		href="tutorial/screenshots/inventoryHelp5.png" class="image"
		title="inventoryHelp5.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp5.png"
		border="1px" align="center"> </a>
		&nbsp;&nbsp;&nbsp;&nbsp; <b>b.</b><a
		href="tutorial/screenshots/inventoryHelp5-2.png" class="image"
		title="inventoryHelp5-2.png" horizontalalign="center"
		target="tutorial/screenshots/inventoryHelp5-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/inventoryHelp5-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/inventoryHelp5-2.png"
		border="1px" align="center"> </a>
		
<br><br> Now the Last Inventory entry for that product shows its prior level and you can repeat Step 3 or 4 to get it right.

</p>

<p>
	<B>Step 6:</B> You may repeat these steps for as many products that you want to inventory today.<p>When you finish, you can return to any other activity by
	selecting it on the navigation bar at the top of the page. 
