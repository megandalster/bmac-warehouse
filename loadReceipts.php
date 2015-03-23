html>
<body>
<?php
include_once('domain/Product.php');
include_once('database/dbProducts.php'); 
include_once('domain/Provider.php');
include_once('database/dbProviders.php'); 
include_once('domain/Contribution.php');
include_once('database/dbContributions.php'); 
// receipt[0] = code
// receipt[1] = receive_date
// receipt[2] = product_source (provider code)
// receipt[3] = payment_source
// receipt[4] = billed_amt
// receiptdetails[0] = code
// receiptdetails[1] = product_code
// receiptdetails[2] = units
// receiptdetails[3] = weight

$receipts = fopen("receipts.csv", "r");
$receiptdetails = fopen("receiptdetails.csv", "r");
if ($receipts && $receiptdetails) {
	$count = 0;
	$rdnext = fgetcsv($receiptdetails);
	$receipt = fgetcsv($receipts);
	//echo ("\nrdnext=");var_dump($rdnext);
    while ($receipt /*&& $count <= 10 */) {
    	$items = array();
    	while ($rdnext[0]==$receipt[0]) { // got a match, find and append items
    	     $p = retrieveByCode_dbProducts($rdnext[1]);
    	     if ($p)
    	         $items[] = $p->get_product_id().":".$rdnext[2].":".$rdnext[3];
    	     else
    	         $items[] = $rdnext[1].":".$rdnext[2].":".$rdnext[3];
    	     $rdnext = fgetcsv($receiptdetails);
    	     //echo ("\nrdnext=");var_dump($rdnext);
    	}
        $v = retrieveByCode_dbProviders($receipt[2]);
        if ($v)
            $v_id = $v->get_provider_id();
        else 
            $v_id = $receipt[2];
        $newdate = make_ship_date($receipt[0],$receipt[1]);
        $c = new Contribution($v_id,$newdate,implode(",",$items),$receipt[3],$receipt[4],"");
        if (!insert_dbContributions($c))
            {echo "<p>not inserted: "; var_dump($c);}
        $receipt = fgetcsv($receipts);
	    $count++;
    }
    echo "count = ".$count;
    fclose($receipts);
    fclose($receiptdetails);
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