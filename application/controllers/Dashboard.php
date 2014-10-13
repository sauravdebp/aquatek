<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/10/14
 * Time: 8:45 PM
 */

class Dashboard extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page, $pageTitle="Unknown Page")
    {
        $folder = "Dashboard/";
        $this->load->view("templates/header", array("pageTitle"=>$pageTitle));
        $this->load->view("pages/" . $folder . $page, $this->data);
        $this->load->view("templates/footer");
    }

    public function home()
    {
        $page = "home";
        $this->index($page, "Dashboard");
    }

    public function browseBills()
    {
        $page = "browseBills";
        $this->load->model('InvoiceTypeModel');
        $this->load->model('InvoiceModel');
        $this->load->model('ConsigneeModel');
        $this->load->library('form_validation');

        $this->data['invoiceTypeVal'] = $this->input->get('invoiceType');
        $this->data['consigneeNameVal'] = $this->input->get('consigneeName');
        $this->data['consigneeTINVal'] = $this->input->get('consigneeTIN');
        $this->data['bookNoVal'] = $this->input->get('bookNo');
        $this->data['invoiceNoVal'] = $this->input->get('invoiceNo');
        $this->data['dateFromVal'] = $this->input->get('dateFrom');
        $this->data['dateUptoVal'] = $this->input->get('dateUpto');
        $where = $this->buildWhere();
        $order = $this->buildOrderBy();
        if($order == "")
            $order = "Order By DOR DESC";

        $this->data['invoiceTypes'] = $this->InvoiceTypeModel->getAllInvoiceTypesAsAssocArray();
        $this->data['invoices'] = $this->InvoiceModel->getAllInvoices($where, $order);
        $this->data['consigneeDetails'] = array();
        foreach($this->data['invoices'] as $invoice)
        {
            $details = $this->ConsigneeModel->getConsigneeDetails($invoice->invoice_consignee);
            $this->data['consigneeDetails'][$invoice->invoice_consignee] = $details->consignee_name;
        }

        $this->index($page, "Dashboard->Browse Invoices");
    }

    public function signOut()
    {
        session_destroy();
    }

    private function buildWhere()
    {
        $invoiceType = $this->input->get('invoiceType');
        $consigneeName = $this->input->get('consigneeName');
        $consigneeTIN = $this->input->get('consigneeTIN');
        $bookNo = $this->input->get('bookNo');
        $invoiceNo = $this->input->get('invoiceNo');
        $dateFrom = $this->input->get('dateFrom');
        $dateUpto = $this->input->get('dateUpto');
        $where = "";

        if(!empty($invoiceType))
        {
            $where .= " invoice_type = $invoiceType And";
        }
        if(!empty($consigneeName))
        {
            $this->load->model('ConsigneeModel');
            $consigneeDetails = $this->ConsigneeModel->getConsigneeDetailsByName($consigneeName);
            if($consigneeDetails != null)
                $where .= " invoice_consignee = '{$consigneeDetails->consignee_tin_no}' And";
        }
        if(!empty($consigneeTIN))
        {
            $where .= " invoice_consignee = '$consigneeTIN' And";
        }
        if(!empty($bookNo))
        {
            $where .= " invoice_book_no = '$bookNo' And";
        }
        if(!empty($invoiceNo))
        {
            $where .= " invoice_no = '$invoiceNo' And";
        }
        if(!empty($dateFrom))
        {
            $where .= " invoice_date >= '$dateFrom' And";
        }
        if(!empty($dateUpto))
        {
            $where .= " invoice_date <= '$dateUpto' And";
        }
        $where = preg_replace('/And$/', '', $where);

        return $where;
    }

    private function buildOrderBy()
    {
        $mapAttrName = array(
            "invoiceDate" => "invoice_date",
            "bookNo" => "invoice_book_no",
            "invoiceNo" => "invoice_no"
        );
        $orderBy = $this->input->get('sortBy');
        $orderOrder = $this->input->get('sortOrder');
        if(!isset($mapAttrName[$orderBy]))
            return "";
        $orderBy = "Order By {$mapAttrName[$orderBy]} $orderOrder";
        return $orderBy;
    }
}