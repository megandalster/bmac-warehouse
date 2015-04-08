<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan 
 */
?>
<?PHP
	session_start();
	session_cache_expire(30);
?>
<html>
	<head>
		<meta HTTP-EQUIV="REFRESH" content="2; url=index.php">
		<title>
			Logged out of RMH Homeroom
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?PHP
					session_unset();
					session_write_close();
				?>
				<p>You are now logged out of Homerestore.</p>
				<?PHP include('footer.inc');?>
			</div>
		</div>
	</body>
</html>