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
	<strong>Information about Your Personal Home Page</strong>
<p>Whenever you log into BMAC-Warehouse, some useful information will
	appear.
<p>
	<B>If you are the Foodbank Director</B>, you should see a menu bar and welcome message that look like this: 
		<BR> </BR>
		<a href="tutorial/screenshots/indexhelp.managermenu.png"
		class="image" title="indexhelp.managermenu.png"
		target="tutorial/screenshots/indexhelp.managermenu.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexhelp.managermenu.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexhelp.managermenu.png"
		border="1px" align="center"> </a> <br> The menu bar leads you to all the actions that are
		available with this software.
</p>
<p>
	<B>If you are a warehouse staff member</B>, you should see a menu bar and welcome message that look like this:
		<BR> </BR>
		<a href="tutorial/screenshots/indexhelp.warehousemenu.png" class="image"
		title="indexhelp.warehousemenu.png"
		target="tutorial/screenshots/indexhelp.warehousemenu.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexhelp.warehousemenu.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexhelp.warehousemenu.png"
		border="1px" align="center"> </a> <br> The menu bar leads you to all the actions that you need to
		process daily shipments, receipts, and the food inventory itself.
</p>		
<p>
    <B>If you are an office staff member</B>, you should see a menu bar and welcome message that look like this:
		<BR> </BR>
		<a href="tutorial/screenshots/indexhelp.officemenu.png" class="image"
		title="indexhelp.officemenu.png"
		target="tutorial/screenshots/indexhelp.officemenu.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexhelp.officemenu.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexhelp.officemenu.png"
		border="1px" align="center"> </a> <br> The menu bar leads you to all the actions that you need to
		view current customers, contributors, and reports on current warehouse activity.
</p>	
<p>
    A summary of <B>recent shipment and receipt activity</B> over the last 30 days should also appear on your home page:
		<BR> </BR>
		<a href="tutorial/screenshots/indexhelp.recentsummary.png" class="image"
		title="indexhelp.recentsummary.png"
		target="tutorial/screenshots/indexhelp.recentsummary.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexhelp.recentsummary.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexhelp.recentsummary.png"
		border="1px" align="center"> </a> <br> You may select any one of these shipments or receipts to view all of its details.
</p>	
<p>
	Finally, <B>If you you've never changed
	your password</B>, you will see the following display: <BR> </BR> <a
		href="tutorial/screenshots/homeHelp2.png" class="image"
		title="homeHelp2.png" target="tutorial/screenshots/homeHelp2.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="tutorial/screenshots/homeHelp2.png"
		width="10%" border="1px" rel="popover"
		data-img="tutorial/screenshots/homeHelp2.png" align="center"> </a> <br>
	You may change your password by entering it and then entering your new
	password twice. After you change your password in this way, it will be
	known only to you. If you forget your password, please contact the
	<a href="mailto:jmathias@bmacww.org">Foodbank Director</a>. Until you change your password, this display continue to
	appear here.
</p>	