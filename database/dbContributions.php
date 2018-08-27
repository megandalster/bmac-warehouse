<?php
/*
 * Copyright 2015 by Moustafa El Badry, Noah Jensen, Dylan Martin, Luis Munguia Orta,
 * David Quennoz, and Allen Tucker. This program is part of BMAC-Warehouse, which is
 * free software.  It comes with absolutely no warranty. You can redistribute and/or
 * modify it under the terms of the GNU General Public License as published by the
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 *
 */
/**
 *
 * Contributions database for BMAC warehouse
 * @author Luis Munguia
 * @version February 13, 2015
 */


include_once(dirname(__FILE__).'/../domain/Contribution.php');
include_once(dirname(__FILE__).'/dbinfo.php');

function retrieve_dbContributions($receive_date){
    $con=connect();
    $query="SELECT * FROM dbContributions WHERE receive_date = '".$receive_date."'";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve contribution on date ".$receive_date. " ". $p->getMessage());
    }
    if($result->rowCount()!== 1){
        $con=null;
        return false;
    }
    $query_row = $result->fetch(PDO::FETCH_ASSOC);
    $theCon = new Contribution($query_row['provider_id'], $query_row['receive_date'],
        $query_row['receive_items'], $query_row['payment_source'],
        $query_row['billed_amt'], $query_row['notes']);
    $con=null;
    return $theCon;
}


function getall_dbContributions(){
    $con=connect();
    $query = "SELECT * FROM dbContributions ORDER BY provider_id";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve from dbContributions ".$p->getMessage());
    }
    $theCons = array();
    while($query_row = $result->fetch(PDO::FETCH_ASSOC)){
        $theCon = new Contribution($query_row['provider_id'], $query_row['receive_date'], $query_row['receive_items'],
            $query_row['payment_source'], $query_row['billed_amt'], $query_row['notes']);
        $theCons[] = $theCon;
    }
    $con=null;
    return $theCons;
}


// retrieve only those Contributions that match the criteria given in the arguments
function getonlythose_dbContributions($provider_id, $receive_date1, $receive_date2, $receive_items) {
    $con=connect();
    $query = "SELECT * FROM dbContributions WHERE provider_id LIKE '%".$provider_id."%'";
    if($receive_date1) $query.= " AND receive_date >= '".$receive_date1.":00:00"."'";
    if($receive_date2) $query.=	" AND receive_date <= '".$receive_date2.":99:99"."'";
    $query.= " AND receive_items LIKE '%".$receive_items."%'";
    $query .= " ORDER BY receive_date DESC";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve contributions ".$p->getMessage());
    }
    $theCons = array();
    while($query_row = $result->fetch(PDO::FETCH_ASSOC)){
        $theCon = new Contribution($query_row['provider_id'], $query_row['receive_date'], $query_row['receive_items'],
            $query_row['payment_source'], $query_row['billed_amt'], $query_row['notes']);
        $theCons[] = $theCon;
    }
    $con=null;
    return $theCons;
}

// variation that matches the provider id exactly for use with provider report
function getonlythose_dbContributions2($provider_id, $receive_date1, $receive_date2) {
    $con=connect();
    $query = "SELECT * FROM dbContributions WHERE provider_id = '".$provider_id."'";
    if($receive_date1) $query.= " AND receive_date >= '".$receive_date1.":00:00"."'";
    if($receive_date2) $query.=	" AND receive_date <= '".$receive_date2.":99:99"."'";
    $query .= " ORDER BY receive_date DESC";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve contributions ".$p->getMessage());
    }
    $theCons = array();
    
    while($query_row = $result->fetch(PDO::FETCH_ASSOC)){
        $theCon = new Contribution($query_row['provider_id'], $query_row['receive_date'], $query_row['receive_items'],
            $query_row['payment_source'], $query_row['billed_amt'], $query_row['notes']);
        $theCons[] = $theCon;
    }
    $con=null;
    return $theCons;
}

// retrieve receipts that match criteria and sort by product_id and date
function retrieve_receipts($payment_source, $receive_date1, $receive_date2) {
    $con=connect();
    $query = "SELECT * FROM dbContributions WHERE payment_source LIKE '%".$payment_source."%'";
    if($receive_date1) $query.= " AND receive_date >= '".$receive_date1.":00:00"."'";
    if($receive_date2) $query.=	" AND receive_date <= '".$receive_date2.":99:99"."'";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve receipts ".$p->getMessage());
    }
    $thequads = array();
    $count = 0;
    while(($query_row = $result->fetch(PDO::FETCH_ASSOC)) /*&& $count<100*/){
        $items = explode(",",$query_row['receive_items']);
        foreach ($items as $item) {
            $it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
            $thequad = $it[0].":".substr($query_row['receive_date'],0,8).":".$query_row['provider_id'].":".$it[2];
            $thequads[] = $thequad;
        }
        $count++;
    }
    $con=null;
    sort($thequads);
    return $thequads;
}

// count receipts for a given product and payment source within the date range
// return the pair "no_receipts:total_wt" as a character string
function count_receipts($product_id, $payment_source, $receive_date1, $receive_date2) {
    $con=connect();
    $query = "SELECT * FROM dbContributions WHERE payment_source LIKE '%".$payment_source."%'";
    $query.= " AND receive_items LIKE '%".$product_id."%' ";
    if($receive_date1!="") $query.= " AND receive_date >= '".$receive_date1.":00:00"."'";
    if($receive_date2!="") $query.=	" AND receive_date <= '".$receive_date2.":23:59"."'";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not retrieve receipts ".$p->getMessage());
    }
    $total_weight = 0;
    $item_count = 0;
    while($query_row = $result->fetch(PDO::FETCH_ASSOC)){
        $items = explode(",",$query_row['receive_items']);
        foreach ($items as $item) {
            $it = explode(":",$item); // $it[0] = product_id, $it[2] = total_wt
            if ($it[0]==$product_id) {
                $total_weight += $it[2];
                $item_count ++;
            }
        }
    }
    $con=null;
    return $item_count.":".$total_weight;
}


function insert_dbContributions($Contribution){
    if(! $Contribution instanceof Contribution){
        return false;
    }
    $con=connect();
    $query = "INSERT INTO dbContributions VALUES ('".
        $Contribution->get_provider_id()."','" .
        $Contribution->get_receive_date()."','".
        implode(',',$Contribution->get_receive_items())."','".
        $Contribution->get_payment_source()."','".
        $Contribution->get_billed_amt()."','".
        $Contribution->get_notes().
        "');";
        try {
            $result = $con->query($query);
        } catch (PDOException $p) {
            die("Could not insert contribution ".$p->getMessage());
        }
        if (!$result) {
            echo ("Unable to insert into dbContributions: " . $Contribution->get_receive_date(). "\n");
            $con=null;
            return false;
        }
        $con=null;
        return true;
}

function update_dbContributions($Contribution){
    if (! $Contribution instanceof Contribution) {
        echo ("Invalid argument for update_dbContributions function call");
        return false;
    }
    if (delete_dbContributions($Contribution->get_receive_date()))
        return insert_dbContributions($Contribution);
    else {
        echo ("Unable to update dbContributions table: ".$Contribution->get_receive_date());
        return false;
    }
}


function delete_dbContributions($receive_date){
    $con=connect();
    $query = "DELETE FROM dbContributions WHERE receive_date =\"".$receive_date."\"";
    try {
        $result = $con->query($query);
    } catch (PDOException $p) {
        die("Could not delete contribution ".$p->getMessage());
    }
    $con=null;
    if (!$result) {
        echo ("Unable to delete from dbContributions: ".$receive_date);
        return false;
    }
    return true;
}
?>