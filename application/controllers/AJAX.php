<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/23/14
 * Time: 8:15 AM
 */

class AJAX extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function consigneeSuggestions()
    {
        $this->load->model('ConsigneeModel');
        $searchAttr = $this->input->get('searchAttribute');
        $keyword = $this->input->get('keyword');
        $result = $this->ConsigneeModel->getMatchingConsigneesByAttr($searchAttr, $keyword);
        $suggestions = array();
        foreach($result as $key=>$res)
        {
            /*$suggestions[$key]['consignee_name'] = $res->consignee_name;
            $suggestions[$key]['consignee_address_street'] = $res->consignee_address_street;
            $suggestions[$key]['consignee_address_city'] = $res->consignee_address_city;
            $suggestions[$key]['consignee_address_state'] = $res->consignee_address_state;
            $suggestions[$key]['consignee_address_pincode'] = $res->consignee_address_pincode;
            $suggestions[$key]['consignee_contact_person'] = $res->consignee_contact_person;
            $suggestions[$key]['consignee_contact_mobile'] = $res->consignee_contact_mobile;*/
            $suggestions[] = $res->$searchAttr;
        }
        $json = json_encode($suggestions);
        echo $json;
    }

    public function consigneeDetailsByTIN()
    {
        $this->load->model('ConsigneeModel');
        $consigneeTIN = $this->input->get("consigneeTIN");
        $details = $this->ConsigneeModel->getConsigneeDetails($consigneeTIN);
        echo json_encode($details);
    }

    public function consigneeDetailsByName()
    {
        $this->load->model('ConsigneeModel');
        $consigneeName = $this->input->get("consigneeName");
        $details = $this->ConsigneeModel->getConsigneeDetailsByName($consigneeName);
        echo json_encode($details);
    }

    public function invoiceItemSuggestions()
    {
        $this->load->model('InvoiceItemModel');
        $keyword = $this->input->get('keyword');
        $result = $this->InvoiceItemModel->getMatchingInvoiceItems($keyword);
        $suggestions = array();
        foreach($result as $key=>$res)
        {
            //$suggestions[$key]['invoice_item_description'] = $res->invoice_item_description;
            $suggestions[] = $res->invoice_item_description;
        }
        $json = json_encode($suggestions);
        echo $json;
    }

    public function accessoryItemSuggestions()
    {
        $this->load->model('AccessoryItemModel');
        $keyword = $this->input->get('keyword');
        $result = $this->AccessoryItemModel->getMatchingAccessoryItems($keyword);
        $suggestions = array();
        foreach($result as $key=>$res)
        {
            $suggestions[] = $res->accessory_item_description;
        }
        $json = json_encode($suggestions);
        echo $json;
    }
}