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
        $page = "addBillItems";
        $this->data['invoiceDetails'] = $this->InvoiceModel->getInvoiceDetails($invoiceId);
        $this->data['invoiceTypes'] = $this->InvoiceTypeModel->getAllInvoiceTypesAsAssocArray();
        $this->data['taxTypes'] = $this->TaxTypeModel->getAllTaxTypes();
        $this->data['unitTypes'] = $this->UnitTypeModel->getAllUnitTypes();
        $this->data['consigneeDetails'] = $this->ConsigneeModel->getConsigneeDetails($this->data['invoiceDetails']->invoice_consignee);
        $this->data['invoiceItems'] = $this->InvoiceModel->getInvoiceItems($invoiceId);

        $this->addBillItemsSubmitHandle($invoiceId);

        $this->index($page, "Add invoice items");
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
        $this->form_validation->set_rules('itemNames', 'Item description', 'required');
        if($this->form_validation->run())
        {
            $itemNames = $this->input->post('itemNames');
            $itemRates = $this->input->post('itemRates');
            $itemUnitTypes = $this->input->post('itemUnits');
            $itemQuantities = $this->input->post('itemQuantities');
            $itemDiscounts = $this->input->post('itemDiscounts');
            $itemTaxRates = $this->input->post('itemTaxRates');

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