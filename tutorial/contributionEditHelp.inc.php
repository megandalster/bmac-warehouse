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
	<strong>Adding, Editing, or Deleting a Receipt</strong>
	</p>
<p>You may add a new receipt, or else edit or delete an existing receipt by following the instructions below.   
</p>
<p><b>Adding a new receipt</b></p>
<p>
	<strong>Step 1: </strong>First, select the <b>receipts</b> box in the top menu bar, and then select <b>Add new receipt</b> to see a page that
	looks like this: 
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp1.png" class="image"
		title="contributionEditHelp1.png"
		target="tutorial/screenshots/contributionEditHelp1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp1.png"
		border="1px" align="middle"> </a>
	<p> Here, the <b>Receipt Date</b> box is preset with today's date along with the time of day ":08:19". The date and time serve as 
	the receipt's unique identifier in the system.  <p>But you can change this preassigned date if the contribution was received prior to than today.  To do this, 
	select a date using the little calendar highlighted above. 
<p>
	<strong>Step 2: </strong>Now click on the <b>Provider</b> box and begin typing the name of your contribution's provider. This will give you a list
	from which you can select your provider (assuming your
	provider is one who has contributed food to BMAC before).  Then select a <b>Payment Source</b> option from the box 
	to the right. Both of these fields are required:
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp1-2.png" class="image"
		title="contributionEditHelp1-2.png"
		target="tutorial/screenshots/contributionEditHelp1-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp1-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp1-2.png"
		border="1px" align="middle"> </a>
	<BR> <BR> Note: if this is a new provider, you should first add that provider to the database as instructed 
	<a href="help.php?helpPage=bmac-warehouse/providerEdit.php">here</a>.  Once added, that provider will show up on this list.	
</p>
<p>
	<strong>Step 3: </strong>One by one, add the products that you received by filling in the appropiate boxes on each line. 
	That is, type the name of the <b>product</b> and the quantity received in <b>case lots</b> or <b>total weight</b>. If you don't enter both,
	the system will compute the other from the product's unit weight, which it knows.
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp2.png" class="image"
		title="contributionEditHelp2.png"
		target="tutorial/screenshots/contributionEditHelp2.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/contributionEditHelp2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp2.png"
		border="1px" align="middle"> </a>
		
</p>
<p>
	If you are adding more than one product, click the <b>add more</b> to create a new line of boxes for the next product, as shown below: 
	
	<BR> <BR><b>a.</b> <a
		href="tutorial/screenshots/contributionEditHelp2-1.png" class="image"
		title="contributionEditHelp2-1.png"
		target="tutorial/screenshots/contributionEditHelp2-1.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/contributionEditHelp2-1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp2-1.png"
		border="1px" align="middle"> </a>
	&nbsp;&nbsp;&nbsp;&nbsp;<b>b.</b> <a
		href="tutorial/screenshots/contributionEditHelp2-2.png" class="image"
		title="contributionEditHelp2-2.png"
		target="tutorial/screenshots/contributionEditHelp2-2.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/contributionEditHelp2-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp2-2.png"
		border="1px" align="middle"> </a>
		
</p>
<p>
	<strong>Step 4: </strong>In the <b>Amount billed</b> box, enter the amount billed. This box is required.
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp3.png" class="image"
		title="contributionEditHelp3.png"
		target="tutorial/screenshots/contributionEditHelp3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp3.png"
		border="1px" align="middle"> </a>
		
</p>
<p>
	<strong>Step 5: </strong>In the <b>Notes</b> box, you may add information about the receipt that is otherwise not specified. This box is optional.
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp4.png" class="image"
		title="contributionEditHelp4.png"
		target="tutorial/screenshots/contributionEditHelp4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp4.png"
		border="1px" align="middle"> </a>
		
</p>
<p>
	<strong>Step 6: </strong>When you're done, hit <b>Submit</b>. 
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp5.png" class="image"
		title="contributionEditHelp5.png"
		target="tutorial/screenshots/contributionEditHelp5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp5.png"
		border="1px" align="middle"> </a>
		
</p>
<p>
	<strong>Step 7: </strong>If you missed a required field, a warning will pop up. In this case, the <b>provider name</b> was left blank. 
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp6.png" class="image"
		title="contributionEditHelp6.png"
		target="tutorial/screenshots/contributionEditHelp6.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp6.png"
		border="1px" align="middle"> </a>
		
</p>
<p>If you didn't make any mistakes, you will be shown a page like this:
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp6-2.png" class="image"
		title="contributionEditHelp6-2.png"
		target="tutorial/screenshots/contributionEditHelp6-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp6-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp6-2.png"
		border="1px" align="middle"> </a>
<p>This means you're done!</p>

<p><b>Editing an existing receipt</b></p>
<p>Editing an existing receipt is very straightforward. You can modify the <b>Provider</b> box if it was misspelt, or pick a different <b>Receipt Date</b>. You can also change 
the <b>Amount billed</b>, or the <b>Notes</b> about the receipt. 
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7.png" class="image"
		title="contributionEditHelp7.png"
		target="tutorial/screenshots/contributionEditHelp7.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7.png"
		border="1px" align="middle"> </a></p>
<p>You can also change the information of the products received, or add missing products. 
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-2.png" class="image"
		title="contributionEditHelp6-2.png"
		target="tutorial/screenshots/contributionEditHelp7-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-2.png"
		border="1px" align="middle"> </a></p>
<p>To delete existing products, simply clear out the row of the product you wish to delete
from the receipt.
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-3.png" class="image"
		title="contributionEditHelp7-3.png"
		target="tutorial/screenshots/contributionEditHelp7-3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-3.png"
		border="1px" align="middle"> </a>
</p>
<p>
	When you're done, hit <b>Submit</b>. 
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-5.png" class="image"
		title="contributionEditHelp5.png"
		target="tutorial/screenshots/contributionEditHelp7-5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-5.png"
		border="1px" align="middle"> </a>
		
</p>
<p>

	If you missed a required field, a warning will pop up. In this case, the <b>provider name</b> was left blank. 
	
	<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-4.png" class="image"
		title="contributionEditHelp7-4.png"
		target="tutorial/screenshots/contributionEditHelp7-4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-4.png"
		border="1px" align="middle"> </a>
		
</p>
<p>If you didn't make any mistakes, you will be shown a page like this:
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-6.png" class="image"
		title="contributionEditHelp7-6.png"
		target="tutorial/screenshots/contributionEditHelp7-6.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-6.png"
		border="1px" align="middle"> </a>
<p>This means you're done!</p>
<p><b>Deleting an existing receipt</b></p>
<p>To delete an existing receipt, <b>check the box shown below</b> and hit <b>delete</b>:
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-7.png" class="image"
		title="contributionEditHelp7-7.png"
		target="tutorial/screenshots/contributionEditHelp7-7.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-7.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-7.png"
		border="1px" align="middle"> </a>
<p>A confirmation that you deleted the receipt will be shown.
<BR> <BR> <a
		href="tutorial/screenshots/contributionEditHelp7-8.png" class="image"
		title="contributionEditHelp7-8.png"
		target="tutorial/screenshots/contributionEditHelp7-8.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/contributionEditHelp7-8.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/contributionEditHelp7-8.png"
		border="1px" align="middle"> </a>
