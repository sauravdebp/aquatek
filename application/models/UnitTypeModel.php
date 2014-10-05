<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/22/14
 * Time: 11:12 AM
 */

class UnitTypeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllUnitTypes()
    {
        $sql = "Select * From unit_types Where DIRTY=0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }

    public function getAllUnitTypeNamesAsArray()
    {
        $types = $this->getAllUnitTypes();
        $typeArr = array();
        foreach($types as $type)
        {
            $typeArr[$type->unit_type_id] = $type->unit_type_name;
        }
        return $typeArr;
    }

    public function getAllUnitTypesInclDirty()
    {
        $sql = "Select * From unit_types";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }
}