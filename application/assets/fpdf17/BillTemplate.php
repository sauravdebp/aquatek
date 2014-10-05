<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/5/14
 * Time: 1:43 PM
 */

//A4 sheet. Unit is mm.
define('PAGE_WIDTH', 210);
define('PAGE_HEIGHT', 297);
define('LEFT_MARGIN', 20);
define('TOP_MARGIN', 10);
define('USABLE_WIDTH', PAGE_WIDTH - 2*LEFT_MARGIN);
define('USABLE_HEIGHT', PAGE_HEIGHT - 2*TOP_MARGIN);

require('fpdf.php');

class Bill
{
    private $pdf = null;
    public $billType;
    public $billDate;
    public $billInvoiceNo;
    public $billBookNo;
    public $billTo;
    public $billConsigneeTIN;
    public $billAuthorisedContactPerson;
    public $billAuthorisedMobileNo;

    public function __construct()
    {
        $this->pdf = new FPDF();
    }

    function createPdf()
    {
        $this->pdf->SetMargins(LEFT_MARGIN, TOP_MARGIN);
        $this->pdf->AddPage();

        $this->topOfBill();

        $this->companyDetails();

        $this->billMetaInfo();

        $this->billTo();

        $this->pdf->Ln();
        $this->pdf->Cell(0, 170, "", 1, 0, 'C');

        $this->pdf->Output();
    }

    private function topOfBill()
    {
        $this->pdf->SetFont('Arial','B',10);
        $cellHeight = 15;
        $this->pdf->Cell(USABLE_WIDTH/2, $cellHeight, "", 1, 0, 'C');
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->Text(LEFT_MARGIN + (USABLE_WIDTH/2 - $this->pdf->GetStringWidth("Signature of person Issuing Retail Invoice"))/2,
            TOP_MARGIN + $cellHeight-1,
            "Signature of person Issuing " . $this->billType . " Invoice");

        $this->pdf->SetFont('Arial','B',20);
        $this->pdf->Cell(USABLE_WIDTH/2, $cellHeight, $this->billType . " INVOICE", 0, 1, 'C');
    }

    private function companyDetails()
    {
        $this->pdf->SetFont('Arial','',20);
        $str = "Aquatek Engineers";
        $this->pdf->Cell(USABLE_WIDTH/2, 10, $str, 0, 1);

        $this->pdf->SetFont('Arial','',9);
        $str =
"Plot No. 57, Udyog Kendra Extension II, ECOTECH - 3
(Near YAMAHA Godown), Greater NOIDA.
Regd. Off: A4/5, Sector 80, Phase II, NOIDA
TIN NO. 0986600552
CST NO. ND-5102447 DT. 01.04.2000
Phone : 9818865593, 9810078390";
        $this->pdf->MultiCell(USABLE_WIDTH/2, 5, $str, 0, "L");
    }

    private function billMetaInfo()
    {
        $cellHeight = 15;
        $padTop = $cellHeight + 12;
        $padLeft = 5;
        $lineGap = 8;
        $tabLength = 50;
        $headingFont = 12;
        $contentFont = 12;
        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop,
            "DATE");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop,
            $this->billDate);

        $this->pdf->SetFont('Arial','',$headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop+$lineGap,
            "INVOICE NO.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop+$lineGap,
            $this->billInvoiceNo);

        $this->pdf->SetFont('Arial','',$headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop+2*$lineGap,
            "BOOK NO.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop+2*$lineGap,
            $this->billBookNo);
    }

    private function billTo()
    {
        $this->pdf->Ln();
        $this->pdf->SetFont('Arial','',10);
        $str = "BILL TO";
        $this->pdf->Cell($this->pdf->GetStringWidth($str)+3, 5, $str, 0, 1);

        $this->pdf->SetFont('Arial','',10);
        $this->pdf->MultiCell(68, 5, $this->billTo, 1, 1);

        $cellHeight = 15;
        $padTop = $cellHeight + 53;
        $padLeft = -6;
        $lineGap = 5;
        $tabLength = 50;
        $headingFont = 10;
        $contentFont = 10;

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop,
            "Consignee TIN No.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop,
            $this->billConsigneeTIN);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + $lineGap,
            "Authorised contact person");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + $lineGap,
            $this->billAuthorisedContactPerson);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 2*$lineGap,
            "Authorised Tel/Mobile No");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 2*$lineGap,
            $this->billAuthorisedMobileNo);
    }
}