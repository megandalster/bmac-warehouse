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
	<strong>Adding and Updating Products</strong>
<p>This page will help you add, update, or delete products in the database.
<p><strong>Updating an Existing Product</strong>
<p>
	<strong>Step 1:</strong> First you need to <strong>search</strong> for
	the product whose information you want to edit. <BR> <BR> <a
		href="tutorial/screenshots/ProductHeader.png" class="image"
		title="ProductHeader.png"
		target="tutorial/screenshots/ProductHeader.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductHeader.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductHeader.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=productSearchHelp.php">click here</a>.
</p>

<p>
	<strong>Step 2:</strong> After finding that product, <strong> click on </strong>
	its name. You will now see a page with all of the product's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/ProductInfo.png" class="image"
		title="ProductInfo.png"
		target="tutorial/screenshots/ProductInfo.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductInfo.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductInfo.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 3:</strong> To change any of the product's information,
	just retype or reselect it. For instance, to change its Funding Source,
	select one of the funding sources from the drop down list. <BR>&nbsp&nbsp REMEMBER: No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>

<p>
	<strong>Step 4:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page:<BR> <BR> <a
		href="tutorial/screenshots/ProductSubmit.png" class="image"
		title="ProductSubmit.png"
		target="tutorial/screenshots/ProductSubmit.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductSubmit.png" rel="popover"
		data-img="tutorial/screenshots/ProductSubmit.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/ProductError.png" class="image"
		title="ProductError.png"
		target="tutorial/screenshots/ProductError.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductError.png" width="10%"
		border="1px" rel="popover"
		data-img="tutorial/screenshots/ProductError.png" align="middle"> </a>
	<BR>&nbsp&nbsp&nbsp *After you have make these corrections, repeat <B>Step
		4</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/ProductEditSuccess.png" class="image"
		title="ProductEditSuccess.png"
		target="tutorial/screenshots/ProductEditSuccess.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductEditSuccess.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductEditSuccess.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.
	
	<p><strong>Adding a New Product</strong>
<p>
	<strong>Step 1:</strong> First, <strong> click on </strong>
	the "Add new Product" link located at the top of the search menu.
	<BR> <BR> <a
		href="tutorial/screenshots/ProductAdd.png" class="image"
		title="ProductAdd.png"
		target="tutorial/screenshots/ProductAdd.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductAdd.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductAdd.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 2:</strong> To change any of the Product
	's information,
	just retype or reselect it. For instance, to change its Funding Source,
	select one of the funding sources from the drop down list.
	<br><i>REMEMBER:</i> No fields marked by <font
		color="#FF0000">*</font> can be left blank.
			<BR> <BR> <a
		href="tutorial/screenshots/ProductNew.png" class="image"
		title="ProductNew.png"
		target="tutorial/screenshots/ProductNew.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductNew.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductNew.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<strong>Step 3:</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page.  You will see a page like this:<BR> <BR> <a
		href="tutorial/screenshots/ProductSubmit.png" class="image"
		title="ProductSubmit.png"
		target="tutorial/screenshots/ProductSubmit.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductSubmit.png" rel="popover"
		data-img="tutorial/screenshots/ProductSubmit.png" width="10%"
		border="1px" align="middle"> </a>
</p>

	<p><strong>Deleting a Product</strong>
<p>
	<strong>Step 1:</strong> navigate to the product you wish to edit, as you would when editting a product.
<p>
	<strong>Step 2:</strong> Second, <strong> click on </strong>
	the checkbox located at bottom of a product's information page. Once the checkbox is checked, you can hit the delete button and remove the product from the database.
	<BR> <BR> <a
		href="tutorial/screenshots/ProductDelete.png" class="image"
		title="ProductDelete.png"
		target="tutorial/screenshots/ProductDelete.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/ProductDelete.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/ProductDelete.png"
		border="1px" align="middle"> </a>
</p>
<p>