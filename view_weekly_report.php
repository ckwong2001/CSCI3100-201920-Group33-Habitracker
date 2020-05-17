<?php
    //include connection file
    require 'db_key.php';
    require 'fpdf182/fpdf.php';
    $connString = connect_db();
    session_start();
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    
    //using FPDF to generate the PDF
    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            $lastSunday = date('Y-m-d',strtotime('last sunday'));
            $dayafterlastSunday = date('Y-m-d',strtotime('last sunday -6 days'));
            $username = $_SESSION['username'];
            
            // Logo
            $this->Image('img/ReportBackground.png',0,0,210);
            $this->Image('img/logo.png',10,5,70);
            
        }
        
        // Page footer
        function Footer()
        {
            // Position at 2.0 cm from bottom
            $this->SetY(-20);
            // Times italic 10
            $this->SetFont('Times','I',10);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            
        }
    }
    $lastSunday = date('Y-m-d',strtotime('last sunday'));
    $dayafterlastSunday = date('Y-m-d',strtotime('last sunday -6 days'));
    //get the goals that were on progress in the previous week
    $result = mysqli_query($connString, "SELECT goal_id, goal_name, streak, streak_lastSun FROM goals WHERE username = '$username' and goal_enddate >= '$dayafterlastSunday'") or die("database error:". mysqli_error($connString));

    $pdf = new PDF();
    //header
    $pdf->AddPage();
    $pdf->AliasNbPages();
    
    $pdf->SetFont('Times','B',13);
    // Move to the right
    $pdf->Cell(80,38,'',0,1,'C');
    // Title
    $pdf->Cell(109,10,"Week: $dayafterlastSunday to $lastSunday",0,1,'L');
    $pdf->Cell(109,10,"User: $username",0,0,'L');
    // Line break
    $pdf->Ln(20);
    
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(40,6,'Goal ID',1,0);
    $pdf->Cell(94,6,'Goal name',1,0);
    $pdf->Cell(55,6,"Streaks as of $lastSunday",1,1);
    
    $pdf->SetFont('Times','',12);
    //display the goal details
    foreach($result as $row) {
        $pdf->Cell(40,10,$row['goal_id'],1,0);
        $pdf->Cell(94,10,$row['goal_name'],1,0);
        $pdf->Cell(55,10,$row['streak_lastSun'],1,1);
    }
    $pdf->Output();
    ?>
