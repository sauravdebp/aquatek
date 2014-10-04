<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:10 AM
 */

class TaxTypeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllTaxTypes()
    {
        $sql = "Select * From tax_types Where DIRTY=0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function getAllTaxTypesInclDirty()
    {
        $sql = "Select * From tax_types";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }
}