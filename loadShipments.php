<html>
<body>
<?php
include_once('Product.php');
include_once('database/dbProducts.php'); 
include_once('Customer.php');
include_once('database/dbCustomers.php'); 
include_once('Shipment.php');
include_once('database/dbShipments.php'); 
// shipment[0] = code
// shipment[1] = ship_date
// shipment[2] = code (customer code)
// shipment[3] = ship_via
// shipment[4] = ship_rate
// shipment[5] = funds_source
// shipmentdetails[0] = code
// shipmentdetails[1] = product_code
// shipmentdetails[2] = units
// shipmentdetails[3] = weight

$shipments = fopen("shipments.csv", "r");
$shipmentdetails = fopen("shipmentdetails.csv", "r");
if ($shipments && $shipmentdetails) {
	$count = 0;
	$rdnext = fgetcsv($shipmentdetails);
	$shipment = fgetcsv($shipments);
	//echo ("\nrdnext=");var_dump($rdnext);
    while ($shipment /*&& $count <= 10 */) {
    	$items = array();
    	$total_weight = 0;
    	while ($rdnext[0]==$shipment[0]) { // got a match, find and append items
    	     $p = retrieveByCode_dbProducts($rdnext[1]);
    	     if ($p)
    	         $items[] = $p->get_product_id().":".$rdnext[2].":".$rdnext[3];
    	     else
    	         $items[] = $rdnext[1].":".$rdnext[2].":".$rdnext[3];
    	     $total_weight += $rdnext[3];
    	     $rdnext = fgetcsv($shipmentdetails);
    	     //echo ("\nrdnext=");var_dump($rdnext);
    	}
    	$v = retrieveByCode_dbCustomers($shipment[2]);
        
    	if ($v)
            $v_id = $v->get_customer_id();
        else 
            $v_id = $shipment[2];
        $newdate = make_ship_date($shipment[0],$shipment[1]);
        $c = new Shipment($v_id,$shipment[5],$newdate,$shipment[3],implode(",",$items),$shipment[4],$total_weight,"","","","");
        if (!insert_dbShipments($c))
            {echo "<p>not inserted: "; var_dump($c);}
        $shipment = fgetcsv($shipments);
	    $count++;
    }
    echo "count = ".$count;
    fclose($shipments);
    fclose($shipmentdetails);
}
function make_ship_date($code,$date){
	$newcode = "0000".$code;
	$newcode = substr($newcode,strlen($newcode)-4);
	$newdate = substr($date,0,8).":".substr($newcode,0,2).":".substr($newcode,2,2);
	return $newdate;
}
?>
</body>
</html>