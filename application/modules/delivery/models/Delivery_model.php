<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Delivery_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object)get_userdata(USER);

        // if(is_empty_object($this->session)){
        // 	redirect(base_url().'login/authentication', 'refresh');
        // }

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }
    
    public function get_po_list()
    {
        $this->db->select('po.ID,po.po_num, po.date_ordered, po.date_added, s.supplier_name');
        $this->db->from($this->Table->purchase_order. ' as po');
        $this->db->join($this->Table->supplier . ' AS s', 'po.supplier_id = s.id', 'left');
        $this->db->where('approved', 0);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get()->result();
     
        return $query;
    }

    
    public function insert_delivery_header($data,$po_num) {
        $this->db->where('po_num', $po_num);
        $this->db->update($this->Table->purchase_order, $data);

        $this->db->select('ID');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('po_num', $po_num);
        $q = $this->db->get()->row();
        // var_dump($q);
        return $q->ID;
    }

    public function update_po_item($data) {
        $this->db->where('po_ID', $data['po_ID']);
        $this->db->update($this->Table->purchase_order_items, $data);
        return true;
    }
}