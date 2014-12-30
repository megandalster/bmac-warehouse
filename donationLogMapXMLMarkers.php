<?php
include_once('database/dbMarkers.php');
include_once('domain/Marker.php');
//require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
$xmlStr=str_replace("+",' ',$xmlStr);
return $xmlStr;
}

$result = getall_dbMarkers();

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
foreach ($result as $row){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row->get_id()) . '" ';
  echo 'address="' . parseToXML($row->get_address()) . '" ';
  echo 'lat="' . $row->get_lat() . '" ';
  echo 'lng="' . $row->get_lng() . '" ';
  echo 'type="' . $row->get_type() . '" ';
  echo 'neighborhood="' . $row->get_neighborhood() . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>