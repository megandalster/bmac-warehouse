<?php

/*
 * Copyright 2013 by Sawyer Bowman, Jim Garvey, Kevin Tabb, Nick Wetzel, and Allen
 * Tucker.  This program is part of Homerestore, which is free software.  It comes
 * with absolutely no warranty.  You can redistribute and/or modify it under the
 * terms of the GNU Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/).
 */

/*
 * Uses the functionality of the 'fpdf' classes to generate a donation report PDF.
 * 
 * @authors Kevin Tabb & Nick Wetzel
 * @version	December 21, 2013
 */

session_start();
session_cache_expire(30);

require("fpdf/fpdf.php");

include_once('database/dbDonationLogs.php');
include_once('domain/DonationLog.php');
include_once('database/dbDonations.php');
include_once('domain/Donation.php');
include_once('database/dbDonors.php');
include_once('domain/Donor.php');

$all_donations = getall_dbDonations_between_dates($_SESSION['donor_name_pdf'], $_SESSION['start_date'], $_SESSION['end_date']);
$type = $_SESSION['type_pdf'];
$headers = explode("?",$_SESSION['pdfHeaders']);


$type_weights = array("Household" => 0,"Appliances" => 0, "Building" => 0, "Other" => 0);

$totals_array = array(0, 0, 0, 0, 0, 0, 0, 0);
$TotalTotal = 0;

$cellPadding = 2;
$cellHeight = 7;

$pdf = new FPDF( );
$pdf->setTitle("Donation Report");

$pdf->AddPage();
// title:
$pdf->SetFont('Times', 'B', 12);
$pdf->SetFillColor(173, 194, 235);

//$pdf->Image("./images/Header4.gif", 150, 14, 50);

if ($type == "foodtype")
{	
	$pdf->Cell(100, 10, 'Habitat for Humanity ReStore Donation Report', 0, 1, 'L');
	
	// print out the header information
	$pdf->SetFont('Times', 'B', 8);
	foreach($headers as $header){	
		$pdf->Cell(100, 8, $header, 0, 1, 'L');
	}
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'B', 6);

}
else
{
	$pdf->Cell(100, 10, 'Habitat for Humanity ReStore Donation Report', 0, 1, 'L');
	
	// print out the header information
	$pdf->SetFont('Times', 'B', 10);
	foreach($headers as $header){
		$pdf->Cell(100, 8, $header, 0, 1, 'L');
	}
	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B', 8);
}

$longest_string = $pdf->GetStringWidth("Donor Name");

foreach ($all_donations as $donation)
{
	if ($pdf->GetStringWidth($donation->get_donor_id()) > $longest_string)
	{
		$longest_string = $pdf->GetStringWidth($donation->get_donor_id());
	}
}

$longest_string += $cellPadding;

// table header
$pdf->Cell($longest_string, $cellHeight, 'Donor Name', 1, 0, 'L', true);

$date_width = $pdf->GetStringWidth('00--00--00') + $cellPadding;
$type_width = $pdf->GetStringWidth('Refrigerated') + $cellPadding;
$total_width = $pdf->GetStringWidth('Total Weight')+ $cellPadding;

if ($type == "foodtype")
{	
	$pdf->Cell($date_width, $cellHeight, 'Date', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Dry Goods', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Dairy', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Bakery', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Meat', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Produce', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Eggs', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Refrigerated', 1, 0, 'L', true);
	$pdf->Cell($type_width, $cellHeight, 'Trash', 1, 0, 'L', true);
	$pdf->Cell($total_width, $cellHeight, 'Total Weight', 1, 1, 'L', true);
}
else
{
	$pdf->Cell($date_width, $cellHeight, 'Date', 1, 0, 'L', true);
	$pdf->Cell($total_width, $cellHeight, 'Total Weight', 1, 1, 'L', true);
}

// remove bold
$pdf->SetFont('');

$colorSwap = 0;
foreach ($all_donations as $donation)
{
	// change the color back and forth on each row
	$colorSwap++;
	if ($colorSwap % 2 == 0)
	{
		$pdf->SetFillColor(221, 221, 221);
	}
	else
	{
		$pdf->SetFillColor(239, 239, 239);
	}
	$pdf->Cell($longest_string, $cellHeight, $donation->get_donor_id(), 1, 0, 'L', true);

	if ($type == "foodtype")
	{
		$pdf->Cell($date_width, $cellHeight, $donation->get_date(), 1, 0, 'L', true);
		$j = 0;
		foreach($type_weights as $item => &$weight)
		{
			$pdf->Cell($type_width, $cellHeight, $donation->get_item_weight($j), 1, 0, 'L', true);
			$weight += $donation->get_item_weight($j);
			$totals_array[$j] += $donation->get_item_weight($j);
			++$j;
		}
	}
	else
	{
		$pdf->Cell($date_width, $cellHeight, $donation->get_date(), 1, 0, 'L', true);
	}
	
	$pdf->Cell($total_width, $cellHeight, $donation->get_item_count(), 1, 1, 'L', true);
	$TotalTotal += $donation->get_item_count();
}
$pdf->SetFillColor(255, 240, 173);
$pdf->Cell(($longest_string + $date_width), $cellHeight, "", 0, 0, 'L', false);
if ($type == "foodtype")
{
	foreach ($totals_array as $itemTotal)
	{
		$pdf->Cell($type_width, $cellHeight, $itemTotal, 1, 0, 'L', true);
	}
}

$pdf->Cell($total_width, $cellHeight, $TotalTotal, 1, 0, 'L', true);

$pdf->Output()

?>