<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Delivery_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        // if(is_empty_object($this->session)){
        // 	redirect(base_url().'login/authentication', 'refresh');
        // }

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function get_po_list()
    {
        $this->db->select('po.ID,po.po_num, po.date_ordered, po.date_added, s.supplier_name,po.date_approved,po.approved');
        $this->db->from($this->Table->purchase_order . ' as po');
        $this->db->join($this->Table->supplier . ' AS s', 'po.supplier_id = s.id', 'left');
        // $this->db->where('approved', 0);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get()->result();

        return $query;
    }


    public function insert_delivery_header($data, $po_num)
    {
        $this->db->where('po_num', $po_num);
        $this->db->update($this->Table->purchase_order, $data);

        $this->db->select('ID');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('po_num', $po_num);
        $q = $this->db->get()->row();
        // var_dump($q);
        return $q->ID;
    }

    public function update_po_item($data,$item_id) {
        $this->db->where('ID', $item_id);
        $this->db->update($this->Table->purchase_order_items, $data);
        return true;
    }

    public function authenticate_user($uname, $pw)
    {
        try {
            if (empty($uname) || empty($pw)) {
                throw new Exception(REQUIRED_FIELD);
            }
            $this->db->select('*');
            $this->db->from($this->Table->user);
            $this->db->where('Username', $uname);
            $query = $this->db->get()->row();

            if ($this->session->ID != $query->ID) {
                throw new Exception(USER_MISMATCH);

            }
            if ($query->Active == 0) {
                throw new Exception(DISABLED_ACCOUNT, true);
            }
            if (empty($query)) {
                throw new Exception(NO_ACCOUNT, true);
            }
            if ($query->Password !== sha1(password_generator($pw, $query->Locker))) {
                throw new Exception(NOT_MATCH, true);
            }

            return array('message' => 'Delivery Approved Successfully', 'has_error' => false);
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'has_error' => true);
        }
    }
}