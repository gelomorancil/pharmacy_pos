<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Item_profiling_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function get_items()
    {
        $this->db->select('*');
        $this->db->where('Active', '1');
        $this->db->from($this->Table->items);
        $this->db->order_by('item_name', 'asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_units()
    {
        $this->db->select('*');
        $this->db->from($this->Table->unit);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_item_profiles()
    {
        $this->db->select('
        ip.*,

        u.unit_of_measure,

        i.item_name,
        i.item_code,
        i.short_name');

        $this->db->from($this->Table->item_profile . ' AS ip');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');
        $this->db->join($this->Table->unit . ' AS u', 'ip.unit_id = u.id', 'left');
        $query = $this->db->get()->result();
        return $query;
    }

}