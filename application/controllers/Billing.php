<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/23/14
 * Time: 8:57 AM
 */

class Billing extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page, $pageTitle="Unknown Page")
    {
        $folder = "Billing/";
        $this->load->view("templates/header", array("pageTitle"=>$pageTitle));
        $this->load->view("pages/" . $folder . $page, $this->data);
        $this->load->view("templates/footer");
    }

    public function newBill()
    {
        $this->load->model('InvoiceTypeModel');
        $this->load->model('InvoiceModel');
        $this->load->helper('url');
        $page = "newBillForm";
        $types = $this->InvoiceTypeModel->getAllInvoiceTypes();
        $this->data['invoiceTypes'] = array();
        foreach($types as $type)
        {
            $this->data['invoiceTypes'][$type->invoice_type_id] = $type->invoice_type_name;
        }
        if(!($invoiceDetails = $this->newBillSubmitHandle()))
            $this->index($page, "New Bill");
        else
        {
            $invoiceId = $this->InvoiceModel->getInvoiceId($invoiceDetails['invoice_type'], $invoiceDetails['invoice_no']);
            redirect('Billing/addBillItems/' . $invoiceId);
        }
    }

    public function addBillItems($invoiceId)
    {
        $this->load->model('InvoiceModel');
        $this->load->model('InvoiceTypeModel');
        $this->load->model('TaxTypeModel');
        $this->load->model('UnitTypeModel');
        $this->load->model('ConsigneeModel');
        $this->load->helper('url');
        $page = "addBillItems";

        if(!$this->addBillItemsSubmitHandle($invoiceId))
        {
            $this->data['invoiceDetails'] = $this->InvoiceModel->getInvoiceDetails($invoiceId);
            $this->data['invoiceTypes'] = $this->InvoiceTypeModel->getAllInvoiceTypesAsAssocArray();
            $this->data['taxTypes'] = $this->TaxTypeModel->getAllTaxTypes();
            $this->data['unitTypes'] = $this->UnitTypeModel->getAllUnitTypes();
            $this->data['consigneeDetails'] = $this->ConsigneeModel->getConsigneeDetails($this->data['invoiceDetails']->invoice_consignee);
            $this->data['invoiceItems'] = $this->InvoiceModel->getInvoiceItems($invoiceId);
        }
        else
        {
            redirect('/Billing/billPdf/'.$invoiceId);
        }
        $this->index($page, "Add invoice items");
    }

    public function addAccessoryItems($invoiceId)
    {
        $page = "addAccessoryItems";
        $this->load->model('UnitTypeModel');

        if(!$this->addAccessoryItemsSubmitHandle($invoiceId))
        {
            $this->data['unitTypes'] = $this->UnitTypeModel->getAllUnitTypes();
            $this->data['accessoryItems'] = $this->InvoiceModel->getAccessoryItems($invoiceId);
        }
        else
        {

        }
        $this->index($page);
    }

    public function billPdf($invoiceId)
    {
        require(dirname(__FILE__) . "/../assets/fpdf17/BillTemplate.php");
        $this->load->model('InvoiceModel');
        $this->load->model('InvoiceTypeModel');
        $this->load->model('TaxTypeModel');
        $this->load->model('UnitTypeModel');
        $this->load->model('ConsigneeModel');

        $invoiceDetails = $this->InvoiceModel->getInvoiceDetails($invoiceId);
        $invoiceTypeDetails = $this->InvoiceTypeModel->getInvoiceTypedetails($invoiceDetails->invoice_type);
        $taxTypes = $this->TaxTypeModel->getAllTaxTypePercAsArray();
        $unitTypes = $this->UnitTypeModel->getAllUnitTypeNamesAsArray();
        $consigneeDetails = $this->ConsigneeModel->getConsigneeDetails($invoiceDetails->invoice_consignee);
        $invoiceItems = $this->InvoiceModel->getInvoiceItems($invoiceId);
        $accessoryItems = $this->InvoiceModel->getAccessoryItems($invoiceId);

        $items = array();
        $itemsAccessory = array();
        $bill = new Bill();

        foreach($invoiceItems as $key=>$item)
        {
            $items[$key]['SL'] = $key+1;
            $items[$key]['DESCRIPTION'] = $item->invoice_item_description;
            $items[$key]['RATE'] = $item->rate;
            $items[$key]['UNIT'] = $unitTypes[$item->unit_type];
            $items[$key]['QTY'] = $item->quantity;
            $items[$key]['DISCOUNT'] = $item->discount_perc;
            $items[$key]['TAX'] = $taxTypes[$item->tax_type];

            $amount = $item->rate * $item->quantity;
            $amount -= $amount * $item->discount_perc/100;
            $bill->billTotal += $amount;
            $bill->billTotalTax += $amount * $items[$key]['TAX']/100;
            $amount += $amount * $items[$key]['TAX']/100;
            $bill->billGrandTotal += $amount;
            $items[$key]['TOTAL'] = $amount;
        }

        foreach($accessoryItems as $key=>$accessory)
        {
            $itemsAccessory[$key]['SL'] = $key + 1;
            $itemsAccessory[$key]['DESCRIPTION'] = $accessory->accessory_item_description;
            $itemsAccessory[$key]['QTY'] = $accessory->quantity;
            $itemsAccessory[$key]['UNIT'] = $unitTypes[$accessory->unit_type];
            $itemsAccessory[$key]['REMARKS'] = $accessory->serial_no . " " . $accessory->remarks;
        }

        $bill->billItems = $items;
        $bill->accessoryItems = $itemsAccessory;
        $bill->billFreight = $invoiceDetails->invoice_freight_charge;
        $bill->billReceived = $invoiceDetails->invoice_received_amount;
        $bill->billGrandTotal += $bill->billFreight;
        $bill->billBalance = $bill->billGrandTotal - $bill->billBalance;
        $bill->billVehicleNo = $invoiceDetails->invoice_vehicle_no;
        $bill->billGrBillTno = $invoiceDetails->invoice_gr_bill_tno;
        $bill->billRoadPermitNo = $invoiceDetails->invoice_road_permit_no;
        $bill->billType = $invoiceTypeDetails->invoice_type_name;
        $bill->billDate = $invoiceDetails->invoice_date;
        $bill->billInvoiceNo = "{$invoiceTypeDetails->invoice_type_initial}-{$invoiceDetails->invoice_no}";
        $bill->billBookNo = $invoiceDetails->invoice_book_no;
        $bill->billConsigneeTIN = $consigneeDetails->consignee_tin_no;
        $bill->billAuthorisedContactPerson = $consigneeDetails->consignee_contact_person;
        $bill->billAuthorisedMobileNo = $consigneeDetails->consignee_contact_mobile;
        $bill->billConsigneeName = $consigneeDetails->consignee_name;
        $bill->billTo = "$consigneeDetails->consignee_name
$consigneeDetails->consignee_address_street
$consigneeDetails->consignee_address_city ($consigneeDetails->consignee_address_state) PIN - $consigneeDetails->consignee_address_pincode";

        $bill->createPdf();
    }

    private function newBillSubmitHandle()
    {
        $this->load->model('InvoiceModel');
        $this->load->model('ConsigneeModel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('invoiceType','Invoice Type','required');
        $this->form_validation->set_rules('invoiceDate','Invoice Date','required');
        $this->form_validation->set_rules('invoiceConsigneeName','Company Name','required');
        $this->form_validation->set_rules('invoiceConsigneeTIN','TIN No.','required');
        $this->form_validation->set_rules('invoiceConsigneeContactPerson','Contact Person Name','required');
        $this->form_validation->set_rules('invoiceConsigneeContactPersonMobile','Contact Person Tel/Mobile No.','required');
        $this->form_validation->set_rules('invoiceConsigneeAddressStreet','Street Address','required');
        $this->form_validation->set_rules('invoiceConsigneeAddressCity','City','required');
        $this->form_validation->set_rules('invoiceConsigneeAddressState','State','required');
        $this->form_validation->set_rules('invoiceConsigneeAddressPincode','Pincode','required');

        if($this->form_validation->run())
        {
            if($this->ConsigneeModel->getConsigneeDetails($this->input->post('invoiceConsigneeTIN')) == null)
            {
                $this->addConsignee();
            }
            else
            {
                //TODO: validate TIN No. with provided details
            }
            $invoiceDetails = array(
                "invoice_type" => $this->input->post('invoiceType'),
                "invoice_date" => $this->input->post('invoiceDate'),
                "invoice_consignee" => $this->input->post('invoiceConsigneeTIN')
            );
            if($this->input->post('invoiceFreightCharge') != "")
                $invoiceDetails['invoice_freight_charge'] = $this->input->post('invoiceFreightCharge');
            if($this->input->post('invoiceGrBillTno') != "")
                $invoiceDetails['invoice_gr_bill_tno'] = $this->input->post('invoiceGrBillTno');
            if($this->input->post('invoiceRoadPermitNo') != "")
                $invoiceDetails['invoice_road_permit_no'] = $this->input->post('invoiceRoadPermitNo');
            if($this->input->post('invoiceVehicleNo') != "")
                $invoiceDetails['invoice_vehicle_no'] = $this->input->post('invoiceVehicleNo');
            $invoiceDetails = $this->InvoiceModel->createNewInvoice($invoiceDetails);
        }
        else
        {
            return false;
        }
        return $invoiceDetails;
    }

    private function addBillItemsSubmitHandle($invoiceId)
    {
        $this->load->model('InvoiceItemModel');
        $this->load->model('InvoiceModel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item', 'Item description', 'required');
        if($this->form_validation->run())
        {
            $itemNames = $this->input->post('item');
            $itemRates = $this->input->post('rate');
            $itemUnitTypes = $this->input->post('unit');
            $itemQuantities = $this->input->post('quantity');
            $itemDiscounts = $this->input->post('discount');
            $itemTaxRates = $this->input->post('tax');

            foreach($itemNames as $key=>$itemName)
            {
                if($itemName == "")
                    continue;
                if(($itemId = $this->InvoiceItemModel->getInvoiceItemIdByDesc($itemName)) == null)
                {
                    $itemDetails = array(
                        'invoice_item_description' => $itemName
                    );
                    $this->InvoiceItemModel->addNewInvoiceItem($itemDetails);
                    $itemId = $this->InvoiceItemModel->getInvoiceItemIdByDesc($itemName);
                }
                $invoiceItemDetails = array(
                    'tax_type' => $itemTaxRates[$key],
                    'quantity' => $itemQuantities[$key],
                    'unit_type' => $itemUnitTypes[$key],
                    'rate' => $itemRates[$key]
                );
                if($itemDiscounts[$key] != "")
                    $invoiceItemDetails['discount_perc'] = $itemDiscounts[$key];
                $this->InvoiceModel->addInvoiceItem($invoiceId, $itemId, $invoiceItemDetails);
            }
        }
        else
        {
            return false;
        }
        return true;
    }

    private function addAccessoryItemsSubmitHandle($invoiceId)
    {
        $this->load->model('AccessoryItemModel');
        $this->load->model('InvoiceModel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item', 'Accessory description', 'required');

        if($this->form_validation->run())
        {
            $itemNames = $this->input->post('item');
            $itemUnitTypes = $this->input->post('unit');
            $itemQuantities = $this->input->post('quantity');
            $itemSerialNos = $this->input->post('serialNo');
            $itemRemarks = $this->input->post('remark');

            foreach($itemNames as $key=>$itemName)
            {
                if($itemName == "")
                    continue;
                if(($itemId = $this->AccessoryItemModel->getAccessoryItemIdByDesc($itemName)) == null)
                {
                    $itemDetails = array(
                        'accessory_item_description' => $itemName
                    );
                    $this->AccessoryItemModel->addNewAccessoryItem($itemDetails);
                    $itemId = $this->AccessoryItemModel->getAccessoryItemIdByDesc($itemName);
                }
                $accessoryItemDetails = array(
                    'quantity' => $itemQuantities[$key],
                    'unit_type' => $itemUnitTypes[$key],
                    'serial_no' => $itemSerialNos[$key],
                    'remarks' => $itemRemarks[$key]
                );
                $this->InvoiceModel->addAccessoryItem($invoiceId, $itemId, $accessoryItemDetails);
            }
        }
        else
        {
            return false;
        }
    }

    private function addConsignee()
    {
        $this->load->model('ConsigneeModel');
        $consigneeDetails = array(
            "consignee_tin_no" => $this->input->post('invoiceConsigneeTIN'),
            "consignee_name" => $this->input->post('invoiceConsigneeName'),
            "consignee_address_street" => $this->input->post('invoiceConsigneeAddressStreet'),
            "consignee_address_city" => $this->input->post('invoiceConsigneeAddressCity'),
            "consignee_address_state" => $this->input->post('invoiceConsigneeAddressState'),
            "consignee_address_pincode" => $this->input->post('invoiceConsigneeAddressPincode'),
            "consignee_contact_mobile" => $this->input->post('invoiceConsigneeContactPersonMobile'),
            "consignee_contact_person" => $this->input->post('invoiceConsigneeContactPerson')
        );
        $this->ConsigneeModel->addNewConsignee($consigneeDetails);
    }
}