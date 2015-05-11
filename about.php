<?PHP
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */
	session_start();
	session_cache_expire(30);
?>

<html>
	<head>
		<title>
			About
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<p><strong>Background</strong><br /><br />
				  
	      		<i>BMAC-Warehouse</i> is a web-based warehouse inventory management system developed by <a href="http://whitman.edu" target="_blank">Whitman College</a> students and an instructor 
	      		for the <a href="http://bmacww.org" target="_blank">Blue Mountain Action Council in Walla Walla, WA</a>. It is
				based on software developed for other non-profits by other student teams during the period 2008-2013.    
 
				<p>This project is supported by the <a href="http://npfi.org" target="_blank">
				Non-Profit FOSS Institute (NPFI)</a>, which "aims to build communities that develop and support customized 
				free and open source software (FOSS) applications that directly benefit the missions of humanitarian 
				non-profit organizations."  NPFI is inspired by the <a href="http://www.hfoss.org" target="_blank">Humanitarian 
				Free and Open Source (HFOSS) Project</a>, which has more global humanitarian goals.
				<p>
				
 				<p><b>System Access and Reuse</b><br /><br />
				Because <i>BMAC-Warehouse</i> must protect the privacy of individual food donors and customers, access to the system by non-BMAC staff members is
				prohibited.  If you are a BMAC staff member and have forgotten your Username or Password, please contact the <a href="mailto:jeffm@bmacww.org">Foodbank Director</a>.
                </p>
				<p> <i>BMAC-Warehouse</i> is free and open source software (see <a href="http://code.google.com/p/bmac-warehouse/" target="_blank">http://code.google.com/p/bmac-warehouse/</a>).  
				From this site, its source code can be freely downloaded and adapted
				 to fit the warehouse inventory management needs of other non-profits.  
				 For more information about the capabilities or adaptability of <i>BMAC-Warehouse</i></i> to other settings, please 
				 contact <a href="mailto:allen@bowdoin.edu">Allen Tucker</a>.
				</p>
				
			</div>
		<?PHP include('footer.inc');?>
		</div>
	</body>
</html>
