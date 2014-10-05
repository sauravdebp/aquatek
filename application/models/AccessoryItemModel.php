<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:25 AM
 */

class AccessoryItemModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addNewAccessoryItem($details = array())
    {
        $this->db->insert('accessory_items', $details);
        return $this->db->trans_status();
    }

    public function getMatchingAccessoryItems($desc)
    {
        //TODO: escape $desc
        $sql = "Select * From accessory_items Where accessory_item_description LIKE '%" . $desc . "%' And DIRTY = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function getAccessoryItemIdByDesc($itemDesc)
    {
        $sql = "Select accessory_id From accessory_items Where accessory_item_description = ?";
        $query = $this->db->query($sql, array($itemDesc));
        if($query->num_rows() == 0)
        {
            return null;
        }
        $row = $query->row();
        return $row->accessory_id;
    }
}