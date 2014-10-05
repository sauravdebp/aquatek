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
    public $billConsigneeName;
    public $billConsigneeAddressStreet;
    public $billConsigneeAddressCity;
    public $billConsigneeAddressState;
    public $billConsigneeAddressPincode;
    public $billAuthorisedContactPerson;
    public $billAuthorisedMobileNo;
    public $billVehicleNo;
    public $billGrBillTno;
    public $billRoadPermitNo;
    public $billItems = array();
    public $accessoryItems = array();
    public $billTotal = 0;
    public $billTotalTax = 0;
    public $billFreight;
    public $billGrandTotal = 0;
    public $billReceived;
    public $billBalance;

    private $widthSL;
    private $widthDesc;
    private $widthRate;
    private $widthUnit;
    private $widthQty;
    private $widthDisc;
    private $widthTax;
    private $widthTotal;
    private $height;

    private $widthSL_a;
    private $widthDesc_a;
    private $widthUnit_a;
    private $widthQty_a;
    private $widthRemarks_a;
    private $height_a;

    public function __construct()
    {
        $this->pdf = new FPDF();
        $this->pdf->SetCreator("Bill Creation Software by @abcdvluprs");
        $this->pdf->SetMargins(LEFT_MARGIN, TOP_MARGIN);
    }

    function createPdf()
    {
        $this->pdf->AddPage();

        $this->topOfBill();

        $this->companyDetails();

        $this->billMetaInfo();

        $this->billTo();

        $this->pdf->Ln();

        $this->billTable();

        $this->disclaimer();

        $this->signatories();

        $this->bottomBorder();

        //Accessory items page
        if(!empty($this->accessoryItems))
        {
            $this->pdf->AddPage();

            $this->accessoryList();
        }

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
        $padTop = $cellHeight + 8;
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
        $padTop = $cellHeight + 33;
        $padLeft = -6;
        $lineGap = 5;
        $tabLength = 50;
        $headingFont = 10;
        $contentFont = 10;

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + $lineGap,
            "Vehicle No.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + $lineGap,
            $this->billVehicleNo);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 2*$lineGap,
            "GR/Bill T No.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 2*$lineGap,
            $this->billGrBillTno);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 3*$lineGap,
            "Road Permit No.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 3*$lineGap,
            $this->billRoadPermitNo);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 4*$lineGap,
            "Consignee TIN No.");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 4*$lineGap,
            $this->billConsigneeTIN);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 5*$lineGap,
            "Authorised contact person");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 5*$lineGap,
            $this->billAuthorisedContactPerson);

        $this->pdf->SetFont('Arial', '', $headingFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft,
            TOP_MARGIN + $padTop + 6*$lineGap,
            "Authorised Tel/Mobile No");
        $this->pdf->SetFont('Arial','',$contentFont);
        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + $tabLength,
            TOP_MARGIN + $padTop + 6*$lineGap,
            $this->billAuthorisedMobileNo);
    }

    private function billHeading()
    {
        $this->widthSL = $this->pdf->GetStringWidth("SL.")+2;
        $this->widthDesc = $this->pdf->GetStringWidth("DESCRIPTION")+35;
        $this->widthRate = $this->pdf->GetStringWidth("RATE")+10;
        $this->widthUnit = $this->pdf->GetStringWidth("UNIT")+8;
        $this->widthQty = $this->pdf->GetStringWidth("QTY")+3;
        $this->widthDisc = $this->pdf->GetStringWidth("DISCOUNT%")+3;
        $this->widthTax = $this->pdf->GetStringWidth("TAX%")+3;
        $this->widthTotal = $this->pdf->GetStringWidth("TOTAL")+8;
        $this->height = 5;

        $this->billItem("SL.", "DESCRIPTION", "RATE", "UNIT", "QTY", "DISCOUNT%", "TAX%", "TOTAL");
    }

    private function billItem($sl, $desc, $rate, $unit, $qty, $disc, $tax, $total, $borders = array())
    {
        $widthExtend = 8;
        if(empty($borders))
        {
            $borders = array(1, 1, 1, 1, 1, 1, 1, 1);
            $widthExtend = 0;
        }
        $this->pdf->Cell($this->widthSL, $this->height, $sl, $borders[0], 0);
        $this->pdf->Cell($this->widthDesc, $this->height, $desc, $borders[1], 0);
        $this->pdf->Cell($this->widthRate, $this->height, $rate, $borders[2], 0);
        $this->pdf->Cell($this->widthUnit, $this->height, $unit, $borders[3], 0);
        $this->pdf->Cell($this->widthQty, $this->height, $qty, $borders[4], 0);
        $this->pdf->Cell($this->widthDisc - $widthExtend, $this->height, $disc, $borders[5], 0);
        $this->pdf->Cell($this->widthTax + $widthExtend, $this->height, $tax, $borders[6], 0);
        $this->pdf->Cell($this->widthTotal, $this->height, $total, $borders[7], 1);
    }

    private function billTable()
    {
        $this->billHeading();

        foreach($this->billItems as $item)
        {
            $this->billItem($item['SL'], $item['DESCRIPTION'], $item['RATE'], $item['UNIT'], $item['QTY'], $item['DISCOUNT'], $item['TAX'], $item['TOTAL']);
        }

        $this->billItem("", "", "", "", "", "", "Total", $this->billTotal, array(0,0,0,0,0,0,1,1));
        $this->billItem("", "", "", "", "", "", "Tax Amt.", $this->billTotalTax, array(0,0,0,0,0,0,1,1));
        $this->billItem("", "", "", "", "", "", "Freight", $this->billFreight, array(0,0,0,0,0,0,1,1));
        $this->billItem("", "", "", "", "", "", "Grand Total", $this->billGrandTotal, array(0,0,0,0,0,0,1,1));
        $this->billItem("", "", "", "", "", "", "Received", $this->billReceived, array(0,0,0,0,0,0,1,1));
        $this->billItem("", "", "", "", "", "", "Balance", $this->billBalance, array(0,0,0,0,0,0,1,1));
    }

    private function disclaimer()
    {
        $padTop = TOP_MARGIN + USABLE_HEIGHT/2 + 71;
        $this->pdf->SetY($padTop);
        $disclaimer = "I Consignee/Authorised representative of consignee have physically checked quantity and quality of above material, and has no complain. I understand that the purchased goods/material will not be taken back and no refund would be given, material if defective can be exchanged within seven days of billing at our expense. I have complete product, and receiving the same with full confidence and satisfaction.";
        $this->pdf->MultiCell(0,5,$disclaimer);
    }

    private function signatories()
    {
        $cellHeight = 15;
        $padTop = $cellHeight + 240;
        $padLeft = 0;
        $lineGap = 8;
        $tabLength = 50;
        $headingFont = 10;
        $contentFont = 12;

        $this->pdf->SetFont('Arial', '', $headingFont);

        $this->pdf->Text(LEFT_MARGIN + $padLeft,
            TOP_MARGIN + $padTop,
            "Signature of Consignee/Authorised Signatory");

        $this->pdf->Text(LEFT_MARGIN + $padLeft,
            TOP_MARGIN + $padTop + 5,
            "Date : ");

        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + 40,
            TOP_MARGIN + $padTop - 5,
            "for Aquatek Engineers");

        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + 40,
            TOP_MARGIN + $padTop,
            "Authorised Signatory");

        $this->pdf->Text(LEFT_MARGIN + USABLE_WIDTH/2 + $padLeft + 40,
            TOP_MARGIN + $padTop + 5,
            "Date : ");
    }

    private function bottomBorder()
    {
        $this->pdf->Line(
            LEFT_MARGIN,
            TOP_MARGIN + USABLE_HEIGHT - 15,
            LEFT_MARGIN + USABLE_WIDTH,
            TOP_MARGIN + USABLE_HEIGHT - 15
        );

        $this->pdf->Line(
            LEFT_MARGIN,
            TOP_MARGIN + USABLE_HEIGHT/2 + 70,
            LEFT_MARGIN + USABLE_WIDTH,
            TOP_MARGIN + USABLE_HEIGHT/2 + 70
        );
    }

    private function accessoryListHeading()
    {
        $this->widthSL_a = $this->pdf->GetStringWidth("SL.")+2;
        $this->widthDesc_a = $this->pdf->GetStringWidth("DESCRIPTION")+50;
        $this->widthQty_a = $this->pdf->GetStringWidth("QTY")+3;
        $this->widthUnit_a = $this->pdf->GetStringWidth("UNIT")+8;
        $this->widthRemarks_a = $this->pdf->GetStringWidth("SL NO. / REMARKS") + 30;
        $this->height_a = 5;

        $this->accessoryItem("SL.", "DESCRIPTION", "QTY", "UNIT", "SL NO. / REMARKS");
    }

    private function accessoryItem($sl, $desc, $qty, $unit, $remarks)
    {
        $this->pdf->Cell($this->widthSL_a, $this->height_a, $sl, 1, 0);
        $this->pdf->Cell($this->widthDesc_a, $this->height_a, $desc, 1, 0);
        $this->pdf->Cell($this->widthQty_a, $this->height_a, $qty, 1, 0);
        $this->pdf->Cell($this->widthUnit_a, $this->height_a, $unit, 1, 0);
        $this->pdf->Cell($this->widthRemarks_a, $this->height_a, $remarks, 1, 1);
    }

    private function accessoryList()
    {
        $this->pdf->cell(0, 5, "Enclosure to Aquatek Engineers {$this->billType} Invoice No. {$this->billInvoiceNo} dated {$this->billDate}", 0, 1);
        $this->pdf->Ln(10);
        $this->pdf->cell(0, 5, "LIST OF ACCESSORIES", 0, 1, "C");
        $this->pdf->Ln();
        $this->accessoryListHeading();

        foreach($this->accessoryItems as $item)
        {
            $this->accessoryItem($item['SL'], $item['DESCRIPTION'], $item['QTY'], $item['UNIT'], $item['REMARKS']);
        }

        $this->pdf->Ln(2);
        $this->pdf->MultiCell(0, 4, "We have checked all above material, physically and found to be correct and there is no physically visible damage, and we confirm the same.");

        $this->pdf->SetY($this->pdf->GetY() + 20);
        $this->pdf->cell(USABLE_WIDTH/2, 5, "for {$this->billConsigneeName}", 0, 0, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "for Aquatek Engineers", 0, 1, "L");
        $this->pdf->Ln(15);
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Name :", 0, 0, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Name :", 0, 1, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Designation :", 0, 0, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Designation :", 0, 1, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Mobile No :", 0, 0, "L");
        $this->pdf->cell(USABLE_WIDTH/2, 5, "Mobile No :", 0, 1, "L");
    }
}