<?PHP
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
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
				  
	      		<i>Homerestore</i> is a web-based truck and volunteer scheduling system developed for the <a href="http://habitathhi.org/restore.htm" target="_blank">Habitat for Humanity Resale Store in Bluffton, South Carolina</a>. It is
				based on software developed in 2013 by four Bowdoin College students and an instructor.  That software was originally implemented in 2012 for the Second Helpings food rescue organization. More information about the original 
				project can be found in an article published in 
				<a href="http://www.islandpacket.com/2013/06/14/2541912/second-helpings-volunteers-get.html" TARGET="_BLANK">The Island Packet</a>.  
 
				<p>This project is supported by <a href="http://npfi.org" target="_blank">
				NPFI</a> and is inspired by the <a href="http://www.hfoss.org" target="_blank">Humanitarian Free and Open Source (HFOSS) Project</a>, which aims to "build a community of academic computing departments,
				IT corporations, and local and global humanitarian and community organizations dedicated to
				building and using Free and Open Source Software to benefit humanity."
				<p>
				
 				<p><b>System Access and Reuse</b><br /><br />
				Because <i>Homerestore</i> must protect the privacy of individual volunteers and donors, access to the system by non-volunteers is
				limited.  If you are a volunteer and have forgotten your Username or Password, please contact the <a href="mailto:aliciwelch@habitathhi.org">Store Manager</a>.
                </p>
				<p> <i>Homerestore</i> is free and open source software (see <a href="http://code.google.com/p/hab-homerestore/" target="_blank">http://code.google.com/p/hab-homerestore/</a>).  
				From this site, its source code can be freely downloaded and adapted
				 to fit the truck and volunteer scheduling needs of other non-profits.  For more information about the capabilities or adaptability of Homerestore to other settings, please contact
either <a href="mailto:allen@npfi.org">Allen Tucker</a> or visit the website <a href="http://npfi.org" target="_blank">http://npfi.org</a>.
				</p>
				<!-- below is the footer that we're using currently-->
				
			</div>
		<?PHP include('footer.inc');?>
		</div>
	</body>
</html>
