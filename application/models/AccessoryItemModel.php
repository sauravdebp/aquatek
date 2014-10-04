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
        parent::__contruct();
        $this->load->database();
    }

    public function getMatchingAccessoryItems($desc)
    {
        //TODO: escape $desc
        $sql = "Select * From accessory_items Where accessory_item_description LIKE '*" . $desc . "*' And DIRTY = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function addNewAccessoryItem($details = array())
    {
        $this->db->insert('accessory_items', $details);
        return $this->db->trans_status();
    }
}