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

class print_journal extends FPDF {
    function header(){

        $this->SetFont('Arial', 'B', '14');
        $this->Cell('276', '5', 'JOURNAL REPORT', '0', '0', 'C');
        $this->ln();

        $this->SetFont('Times', '', '12');
        $this->Cell('276', '10', 'The Journal Record of the firm', '0', '0', 'C');
        $this->ln(20);
    }

    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '', '8');
        $this->Cell('0', '10', 'Page' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->ln();
    }

    function header_table(){
        $this->SetLeftMargin(45); //for the alignment of the table
        $this->SetFont('Times', 'B', '12');
        $this->Cell('35', '10', 'Date', '1', '0', 'C');
        $this->Cell('35', '10', 'Description', '1', '0', 'C');
        $this->Cell('35', '10', 'Ref.', '1', '0', 'C');
        $this->Cell('35', '10', 'Account', '1', '0', 'C');
        $this->Cell('35', '10', 'Debit', '1', '0', 'C');
        $this->Cell('35', '10', 'Credit', '1', '0', 'C');
        $this->ln();
    }

    function view_table()
    {
        $this->SetFont('Times', 'B', '12');
        global $conn_oop;

        $sql = "SELECT * FROM journal";
        $result = $conn_oop->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //converting the date into proper format
                $timestamp = strtotime($row["date"]);
                //first line of the table
                $this->Cell('35', '10', date("m-d-Y", $timestamp), '1', '0', 'C');
                $this->Cell('35', '10', $row["journal"], '1', '0', 'C');
                $this->Cell('35', '10', $row["reference"], '1', '0', 'C');
                $this->Cell('35', '10', $row["account"], '1', '0', 'C');
                $this->Cell('35', '10', $row["debit"], '1', '0', 'C');
                $this->Cell('35', '10', '', '1', '0', 'C');
                $this->ln();

                //second line of the table
                $this->Cell('35', '10', '', '1', '0', 'C');
                $this->Cell('35', '10', $row["journal"], '1', '0', 'C');
                $this->Cell('35', '10', $row["reference"], '1', '0', 'C');
                $this->Cell('35', '10', '', '1', '0', 'C');
                $this->Cell('35', '10', '', '1', '0', 'C');
                $this->Cell('35', '10', $row["credit"], '1', '0', 'C');
                $this->ln();


            }

        } else {
            echo "0 results";
        }
        $conn_oop->close();
    } //end of view table function



} //end of class print_inventory

$pdf = new print_journal();
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4', 0);
$pdf->header_table();
$pdf->view_table();
$pdf->Output();
