<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:20 AM
 */

class InvoiceItemModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMatchingInvoiceItems($desc)
    {
        //TODO: escape $desc
        $sql = "Select * From invoice_items Where invoice_item_description LIKE '%" . $desc . "%' And DIRTY = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function addNewInvoiceItem($details = array())
    {
        $this->db->insert('invoice_items', $details);
        return $this->db->trans_status();
    }

    public function getInvoiceItemIdByDesc($itemDesc)
    {
        $sql = "Select invoice_item_id From invoice_items Where invoice_item_description = ?";
        $query = $this->db->query($sql, array($itemDesc));
        if($query->num_rows() == 0)
        {
            return null;
        }
        $row = $query->row();
        return $row->invoice_item_id;
    }
}