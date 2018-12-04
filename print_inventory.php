<?php
session_start();
include 'config.php';
require 'fpdf.php';
include 'functions.php';

//if the user is unable to login then redirect to the login page
if (!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}

class print_inventory extends FPDF
{
    function header()
    {
        $this->SetFont('Arial', 'B', '14');
        $this->Cell('276', '5', 'INVENTORY REPORT', '0', '0', 'C');
        $this->ln();

        $this->SetFont('Times', '', '12');
        $this->Cell('276', '10', 'The Inventory Record of the firm', '0', '0', 'C');
        $this->ln(20);
    }

    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', '8');
        $this->Cell('0', '10', 'Page' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->ln();
    }

    function header_table()
    {
        $this->SetFont('Times', 'B', '12');
        $this->Cell('35', '10', 'Date & Time', '1', '0', 'C');
        $this->Cell('35', '10', 'Product ID', '1', '0', 'C');
        $this->Cell('25', '10', 'Quantity', '1', '0', 'C');
        $this->Cell('35', '10', 'Item', '1', '0', 'C');
        $this->Cell('35', '10', 'Unit Price', '1', '0', 'C');
        $this->Cell('35', '10', 'Tax(15%)', '1', '0', 'C');
        $this->Cell('25', '10', 'Discount', '1', '0', 'C');
        $this->Cell('35', '10', 'Total', '1', '0', 'C');
        $this->ln();
    }

    function view_table()
    {
        $this->SetFont('Times', 'B', '12');
        global $conn_oop;

        $subtotal = 0;

        $sql = "SELECT * FROM inventory_report";
        $result = $conn_oop->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //converting the date into proper format
                $timestamp = strtotime($row["date"]);

                $this->Cell('35', '10', date("m-d-Y", $timestamp), '1', '0', 'C');
                $this->Cell('35', '10', $row["product_id"], '1', '0', 'C');
                $this->Cell('25', '10', $row["quantity"], '1', '0', 'C');
                $this->Cell('35', '10', $row["item"], '1', '0', 'C');
                $this->Cell('35', '10', $row["unit_price"], '1', '0', 'C');
                $this->Cell('35', '10', $row["tax"], '1', '0', 'C');
                $this->Cell('25', '10', $row["discount"], '1', '0', 'C');
                $this->Cell('35', '10', $row["total"], '1', '0', 'C');
                $this->ln();

                $subtotal = $subtotal + $row["total"];

            }
            $this->Cell('35', '10', 'Subtotal', '1', '0', 'C');
            $this->Cell('225', '10', $subtotal, '1', '0', 'R');


        } else {
            echo "0 results";
        }
        $conn_oop->close();
    } //end of view table function


} //end of class print_inventory

$pdf = new print_inventory();
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4', 0);
$pdf->header_table();
$pdf->view_table();
$pdf->Output();
