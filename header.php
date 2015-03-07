<!--
/*
 * Copyright 2013 by ... and Allen Tucker.  
 This program is part of Homerestore, which is free software.  It comes 
 * with absolutely no warranty.  You can redistribute and/or modify it under the 
 * terms of the GNU Public License as published by the Free Software Foundation 
 * (see <http://www.gnu.org/licenses/).
*/
-->

<style type="text/css">
h1 {padding-left: 0px; padding-right:165px;}
</style>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>

<div id="header"></div>
<div align="center" id="navigationLinks">

<div id="logo" style="visibility:hidden; position:absolute; top:0px; left:0px">
<a href="#top"><img src="./images/bmaclogo,png.png" style="height:48px; width:auto"></a>
</div>

<div>
<?PHP
	//Log-in security
	//If they aren't logged in, display our log-in form.
	if(!isset($_SESSION['logged_in'])){
		include('login_form.php');
		die();
	}
	else if($_SESSION['logged_in']){

		/**
		 * Set our permission array for staff logging in.
		 * If a page is not specified in the permission array, anyone logged into the system
		 * can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
		//pages guests can view
		$permission_array['index.php']=0;
		$permission_array['about.php']=0;
		$permission_array['donationLogView.php']=1;
		$permission_array['viewDonation1.php']=1;
		$permission_array['viewDonation2.php']=1;
		$permission_array['scheduleView.php']=1;
		//additional pages team captains, coordinators, and boardmembers can view
		$permission_array['donorSearch.php']=2;
		$permission_array['donorEdit.php']=2;
		$permission_array['personSearch.php']=2;
		$permission_array['personSearch.php']=2;
		$permission_array['personEdit.php']=2;
		$permission_array['viewReports.php']=2;
		
		//check if they're at a valid page for their access level.
		$current_page = substr($_SERVER['PHP_SELF'],1);
		
		if($permission_array[$current_page]>$_SESSION['access_level']){
			//in this case, the user doesn't have permission to view this page.
			//we redirect them to the index page.
			echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
			//note: if javascript is disabled for a user's browser, it would still show the page.
			//so we die().
			die();
		}

		//This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
		$path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']),strpos(strrev($_SERVER['SCRIPT_NAME']),'/')));
		
		$today=date("y-m-d");
		$week_earlier = date("y-m-d", strtotime("-1 week"));
		//they're logged in and session variables are set.
		echo('<a href="'.$path.'index.php">home</a>');
		echo(' | <a href="about.php'.'">about</a>');
		if ($_SESSION['access_level']==1) { // office staff
			echo(' | <a href="'.$path.'providerSearch.php'.'">providers</a>');
	    	echo(' | <a href="'.$path.'customerSearch.php'.'">customers</a>');
			echo(' | <a href="'.$path.'personSearch.php">reports</a>');		}
		if($_SESSION['access_level']==2) {  // warehouse staff
			echo(' | <a href="' . $path . 'shipmentSearch.php?date='.$today.'">shipments</a>'); 
			echo(' | <a href="' . $path . 'contributionSearch.php?date='.$today.'">receipts</a>'); 
			echo(' | <a href="' . $path . 'productSearch.php?date='.$today.'">products</a>'); 
		}
	    if($_SESSION['access_level']==3) { // manager
	        echo(' | <a href="' . $path . 'shipmentSearch.php?date='.$today.'">shipments</a>'); 
			echo(' | <a href="' . $path . 'contributionSearch.php?date='.$today.'">receipts</a>'); 
			echo(' | <a href="' . $path . 'productSearch.php?date='.$today.'">products</a>'); 
			echo(' <br><a href="'.$path.'personSearch.php?date='.$today.'">staff</a>');
	        echo(' | <a href="'.$path.'providerSearch.php'.'">providers</a>');
	    	echo(' | <a href="'.$path.'customerSearch.php'.'">customers</a>');
			echo(' | <a href="'.$path.'personSearch.php">reports</a>');	
	    }
	    echo(' | <a href="'.$path.'help.php?helpPage='.$current_page.'" target="_BLANK"><b>help</b></a>');
	    echo(' | <a href="'.$path.'logout.php"> logout</a>');
		echo "<br>";
	}
?>
</div>
</div>
<script>
var normalTop = $('#navigationLinks').offset().top;
var offset = $('#navigationLinks').outerHeight()
$window = $(window);

$("a[href='#top']").click(function() {
	  $("html, body").animate({ scrollTop: 0 }, "slow");
	  return false;
});

$window.scroll(function() {
if($window.scrollTop() >= normalTop) {
	$('#navigationLinks').css({          
    	position: "fixed",
    	width: "90%",
    	top: 0,
    	left: 0,
    	right: 0,
    	borderBottom: "2px solid #264576",
       	borderLeft: "",
       	borderRight: "",
	})
	
	$('#logo').css({          
		visibility: "visible"
	})

	$('#header').css({          
		marginBottom: offset
	})
} else {
	$('#navigationLinks').css({
		position: "static",
		width: "auto",
    	borderBottom: "",
       	borderLeft: "2px solid #264576",
       	borderRight: "2px solid #264576",
	})
	
	$('#logo').css({          
		visibility: "hidden"
	})
	
	$('#header').css({          
		marginBottom: 0
	})
}
});
</script>
<!-- End Header -->