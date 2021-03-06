<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:27 AM
 */

class InvoiceModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function createNewInvoice($invoiceDetails = array())
    {
        $invoiceDetails['invoice_no'] = $this->assignInvoiceNo($invoiceDetails['invoice_type']);
        $invoiceDetails['invoice_book_no'] = $this->assignBookNo($invoiceDetails['invoice_no'], 50);
        $this->db->insert('invoice', $invoiceDetails);
        if(!$this->db->trans_status())
        {
            return false;
        }
        return $invoiceDetails;
    }

    public function addInvoiceItem($invoiceId, $invoiceItemId, $details)
    {
        $details['invoice_id'] = $invoiceId;
        $details['invoice_item_id'] = $invoiceItemId;
        $this->db->insert('invoice_invoiceitem_map', $details);
        return $this->db->trans_status();
    }

    public function addAccessoryItem($invoiceId, $accessoryItemId, $details)
    {
        $details['invoice_id'] = $invoiceId;
        $details['accessory_item_id'] = $accessoryItemId;
        $this->db->insert('invoice_accessoryitem_map', $details);
        return $this->db->trans_status();
    }

    public function updateInvoiceDetails($invoiceId, $details)
    {
        $this->db->update('invoice', $details, "invoice_id = $invoiceId");
        return $this->db->trans_status();
    }

    public function updateReceivedAmount($invoiceId, $amount)
    {
        $details = array(
            "invoice_received_amount" => $amount
        );
        $this->updateInvoiceDetails($invoiceId, $details);
    }

    public function getInvoiceId($invoiceTypeId, $invoiceNo)
    {
        $sql = "Select invoice_id From invoice Where invoice_type = ? And invoice_no = ?";
        $query = $this->db->query($sql, array($invoiceTypeId, $invoiceNo));
        if($query->num_rows() == 0)
        {
            return null;
        }
        $row = $query->row();
        return $row->invoice_id;
    }

    public function getInvoiceDetails($invoiceId)
    {
        $sql = "Select * From invoice Where invoice_id = ?";
        $query = $this->db->query($sql, array($invoiceId));
        if($query->num_rows() == 0)
        {
            return null;
        }
        return $query->row();
    }

    public function getInvoiceItems($invoiceId)
    {
        $sql = "Select invoice_items.*, tax_type, discount_perc, quantity, unit_type, rate
                From invoice_invoiceitem_map
                  Join invoice_items On invoice_invoiceitem_map.invoice_item_id = invoice_items.invoice_item_id
                Where invoice_id = ? And invoice_invoiceitem_map.DIRTY = 0";
        $query = $this->db->query($sql, array($invoiceId));
        return $query->result();
    }

    public function getAccessoryItems($invoiceId)
    {
        $sql = "Select accessory_items.*, quantity, unit_type, serial_no, remarks
                From invoice_accessoryitem_map
                  Join accessory_items On invoice_accessoryitem_map.accessory_item_id = accessory_items.accessory_id
                Where invoice_id = ? And invoice_accessoryitem_map.DIRTY = 0";
        $query = $this->db->query($sql, array($invoiceId));
        return $query->result();
    }

    public function getAllInvoices($where="", $orderBy="")
    {
        $sql = "Select * From invoice Where DIRTY=0";
        if($where != "")
        {
            $sql .= " AND $where";
        }
        $sql .= " $orderBy";
        $query = $this->db->query($sql);
        return $query->result();
    }

    private function assignInvoiceNo($invoiceTypeId)
    {
        $sql = "Select invoice_no From invoice Where invoice_type = ? Order By invoice_no Desc Limit 1";
        $query = $this->db->query($sql, array($invoiceTypeId));
        if($query->num_rows() == 0)
        {
            //TODO: Create a constant INVOICE_NUMBER_START
            return 1;
        }
        $row = $query->row();
        return $row->invoice_no + 1;
    }

    private function assignBookNo($invoiceNo, $invoicesPerBook = 50)
    {
        //TODO: Create a default INVOICES_PER_BOOK constant
        return ($invoiceNo/$invoicesPerBook) + 1;
    }
}