<?php
/*
 * Copyright 2014 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/**
 *  This file implements a Google Map view of all Pick-ups in a given day.
 *  
 *  @author Allen Tucker
 *  @version July 13, 2014
 */
 
	session_start();
	session_cache_expire(30);
	
	// Setting the default time zone
	date_default_timezone_set('America/New_York');
?>
<html>
	<head>
		<title>
			Daily Pick-up Map View
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
		
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      HHI: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      SUN: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },
      BFT: {
          icon: 'http://labs.google.com/ridefinder/images/mm_20_brown.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(32.23766, -80.86961),
        zoom: 11,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("donationLogMapXMLMarkers.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var neighborhood = markers[i].getAttribute("neighborhood");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + neighborhood;
          var icon = customIcons[type] || {};
          
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>

  </script>
		
		
	</head>
	<body onload="load()">
		<div id="container">
			<?php include('header.php');?>
			<div id="content">
				<?php 
				include_once('database/dbDonationLogs.php');
				include_once('domain/DonationLog.php');
	//			include_once('database/dbMarkers.php');
	//			include_once('domain/Marker.php');
                $areas = array("HHI"=>"Truck 1", "SUN"=> "Truck 2", "BFT"=> "DECON");
				$thisDay = $_GET['date'];
				$thisArea = $_GET['area'];
				$today = date('y-m-d');	
				$todayUTC = time();
				$thisUTC = mktime(0,0,0,substr($thisDay,3,2),substr($thisDay,6,2),substr($thisDay,0,2));
				$nextdayUTC = $thisUTC + 86400;
				$prevdayUTC = $thisUTC - 86400;
				echo "<p style='font-size:12px'><b>Truck Schedule Map View for ".date('l F j, Y', $thisUTC)."</b>";
				echo "<br>"
				?>

    <div id="map" style="width: 600px; height: 400px"></div>
	
</div>		
<?php include('footer.inc');?>
</div>
</body>
</html>
