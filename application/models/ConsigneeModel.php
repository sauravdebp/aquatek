<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:13 AM
 */

class ConsigneeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMatchingConsigneesByAttr($attr, $val)
    {
        //TODO: escape $val
        $sql = "Select * From consignee Where $attr LIKE '%" . $val . "%' And DIRTY = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function getConsigneeDetails($consigneeTIN)
    {
        $sql = "Select * From consignee Where consignee_tin_no = ?";
        $query = $this->db->query($sql, array($consigneeTIN));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function getConsigneeDetailsByName($consigneeName)
    {
        $sql = "Select * From consignee Where consignee_name = ?";
        $query = $this->db->query($sql, array($consigneeName));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function addNewConsignee($details = array())
    {
        $this->db->insert('consignee', $details);
        return $this->db->trans_status();
    }
}