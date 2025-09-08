<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Management_model extends CI_Model
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

    public function get_user(){
        $this->db->select('*');
        $this->db->where('Active', 1);
        $this->db->where('Username !=', "superadmin_xoxo");
        $this->db->from($this->Table->user);
        $this->db->order_by('LName','asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_user_for_edit(){
        $this->db->select('*');
        $this->db->from($this->Table->user);
        $this->db->where('ID', $this->user_id);

        $query = $this->db->get()->row();
        return $query;
    }

    public function get_user_role(){
        $this->db->select('*');
        $this->db->from($this->Table->role);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_items(){
        $this->db->select('*');
        $this->db->from($this->Table->items);
        $query = $this->db->get()->result();
        return $query;
    }
    public function get_items_active(){
        $this->db->select('*');
        $this->db->where('Active', 1);
        $this->db->from($this->Table->items);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_suppliers(){
        $this->db->select('*');
        $this->db->from($this->Table->supplier);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_suppliers_active(){
        $this->db->select('*');
        $this->db->where('Active', 1);
        $this->db->from($this->Table->supplier);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_units(){
        $this->db->select('*');
        $this->db->from($this->Table->unit);
        $query = $this->db->get()->result();
        return $query;
    }
    
    public function check_nearly_expired_stocks() {
        $this->db->where("item_expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY)");
        $query = $this->db->get($this->Table->items);
        return $query->num_rows() > 0;
    }

    public function get_items_expiry() {
        $this->db->select('i.item_name, i.item_expiry_date, inv.quantity');
        $this->db->join($this->Table->item_profile . ' AS it', 'inv.item_profile_id = it.id', 'left');
        $this->db->join($this->Table->items . ' AS i', 'it.item_id = i.id', 'left');
        $this->db->from($this->Table->inventory.' as inv');
        $this->db->where("i.item_expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY)");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_buyers(){
        $this->db->select('*');
        $this->db->from($this->Table->buyers);
        $this->db->where('ID !=', 1);
        $this->db->order_by('FName','asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_buyers_details(){
        $this->db->select('*');
        $this->db->from($this->Table->buyers);
        $this->db->where('ID', $this->buyer_id);

        $query = $this->db->get()->row();
        return $query;
    }
}
