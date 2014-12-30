<?php
/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 *  This file implements the viewing list of all Pick-ups in a given day.
 *  
 *  @author Allen Tucker, Sawyer Bowman & Nick Wetzel 
 *  @version December 21, 2013
 */
 
	session_start();
	session_cache_expire(30);
	
	// Setting the default time zone
	date_default_timezone_set('America/New_York');
?>
<html>
	<head>
		<title>
			Daily Pick-up Log
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?php include('header.php');?>
			<div id="content">
				<?php 
				include_once('database/dbDonationLogs.php');
				include_once('domain/DonationLog.php');
                include_once('database/dbMarkers.php');
				include_once('domain/Marker.php');
                $areas = array("HHI"=>"Truck 1", "SUN"=> "Truck 2", "BFT"=> "DECON");
				$thisDay = $_GET['date'];
				$today = date('y-m-d');	
				$todayUTC = time();
				$thisUTC = mktime(0,0,0,substr($thisDay,3,2),substr($thisDay,6,2),substr($thisDay,0,2));
				$nextdayUTC = $thisUTC + 86400;
				$prevdayUTC = $thisUTC - 86400;
				echo "<p style='font-size:12px'><b>Truck Schedule for ".date('l F j, Y', $thisUTC)."</b>";
				
	echo "<table><tr><td class='padded'><a href=donationLogView.php?date=".date('y-m-d',$prevdayUTC)."><< Previous Day</a></td>";
	echo "<td></td><td></td>";
	echo "<td class='padded'><a href=donationLogView.php?date=".date('y-m-d',$nextdayUTC).">Next Day >></a></td>";	
?>
</tr>
	<tr>
		<td class="padded"><b>Time Recorded</b></td>
		<td class="padded"><b>Donor *</b></td>
		<td class="padded"><b>Latitude</b></td>
		<td class="padded"><b>Longitude</b></td>
		<td class="padded"><b>Items</b></td>	
		<td class="padded"><b>Route</b></td>
<?php
	echo("<td class='padded'>");
	echo("<button type='submit' form='addDonation'><b>Add Pick-up</b></button>");
		
	$todaysDonationLog = get_donationLog($thisDay);
	if (!$todaysDonationLog) { // if there isn't one, make one
		$newone = new DonationLog($thisDay,"","","");
		insert_dbDonationLogs($newone);
		$todaysDonationLog = get_donationLog($newone);
	}	
	// first check if the log is empty
	if($todaysDonationLog->get_num_donations()>0){
		echo("<button type='submit' form='viewMap'><b>View Map</b></button></tr>");
		create_dbMarkers();		// empty the markers table fromt the last map
		// if not empty then display each donation
		  foreach ($todaysDonationLog->get_donations() as $aDonationID){	
			$aDonation = retrieve_dbDonations($aDonationID);
			if ($aDonation){
				$aDonor = retrieve_dbDonors($aDonation->get_donor_id());
				echo '<tr><td class="padded">'.$aDonation->get_id().'</td>';
				if ($aDonor) {		
					echo '<td class="padded"><a href="viewDonation2.php?donationID='.$aDonation->get_id().'">'.$aDonation->get_donor_id().'</a><br>'
						.$aDonor->get_address()."<br>".$aDonor->get_city().", ".$aDonor->get_state()." ".$aDonor->get_zip().'</td>';
				    echo '<td class="padded">'.$aDonor->get_lat().'</td>';
					echo '<td class="padded">'.$aDonor->get_lng().'</td>';
					$aMarker = new Marker ($aDonor->get_id(),$aDonor->get_mapAddress(),
							$aDonor->get_lat(), $aDonor->get_lng(),$aDonation->get_area(), $aDonor->get_neighborhood());
							insert_dbmarkers($aMarker);
				}
				else
					echo '<td class="padded"><a href="viewDonation2.php?donationID='.$aDonation->get_id().'">'.$aDonation->get_donor_id().'</a></td>';
				echo '<td class="padded">'.$aDonation->get_item_count().'</td>';
				echo '<td class="padded">'.$areas[$aDonation->get_area()].'</td></tr>';
				
			}
		}
	}
	?>	
</table>	
<p><b>* </b>View, edit or remove a pick-up by selecting its Donor.</p>

<form name="addDonation" id="addDonation" action="viewDonation2.php" method="get">
	<input type="hidden" name="donationID" id="donationID" value="new">
	<input type="hidden" name="date" id="date" value="<?php echo $thisDay;?>">
</form>
<form name="viewMap" id="viewMap" action="donationLogMapView.php" method="get">
	<input type="hidden" name="date" id="date" value="<?php echo $thisDay;?>">
</form>
</div>
			
<?php include('footer.inc');?>
</div>
</body>
</html>