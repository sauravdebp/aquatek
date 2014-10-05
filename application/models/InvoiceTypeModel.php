<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:05 AM
 */

class InvoiceTypeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getInvoiceTypeDetails($typeId)
    {
        $sql = "Select * From invoice_types Where invoice_type_id = ?";
        $query = $this->db->query($sql, array($typeId));
        return $query->row();
    }

    public function getAllInvoiceTypes()
    {
        $sql = "Select * From invoice_types Where DIRTY=0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function getAllInvoiceTypesAsAssocArray()
    {
        $types = $this->getAllInvoiceTypes();
        $invoiceTypes = array();
        foreach($types as $type)
        {
            $invoiceTypes[$type->invoice_type_id] = $type->invoice_type_name;
        }
        return $invoiceTypes;
    }

    public function getAllInvoiceTypesInclDirty()
    {
        $sql = "Select * From invoice_types";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }
}