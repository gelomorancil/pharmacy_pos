<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Expense_model extends CI_Model
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

public function get_expenses()
{
    $this->db->select(
        'e.Branch as e_Branch,
         e.ID,
         e.Image,
         e.Date,
         e.Descr,
         e.Actual_Money,
         e.expense,
         e.Balance,
         e.Editted,
         u.FName,
         u.LName'
    );

    $this->db->from($this->Table->expenses . ' e');
    $this->db->join($this->Table->user . ' u', 'u.ID = e.Incharge', 'left');
    $this->db->where('e.Void', 0);

    // ✅ Date filter
    if (!empty($this->date_from) && !empty($this->date_to)) {

        $this->db->where('e.Date >=', $this->date_from);
        $this->db->where('e.Date <=', $this->date_to);

    } else {

        // ✅ Default: today (full day range)
        $today = date('Y-m-d');
        $this->db->where('e.Date >=', $today . ' 00:00:00');
        $this->db->where('e.Date <=', $today . ' 23:59:59');
    }

    return $this->db->get()->result();
}

    public function get_expense_details(){
        $this->db->select('*');
        $this->db->from($this->Table->expenses);
        $this->db->where('ID', $this->exp_id);

        $query = $this->db->get()->row();
        return $query;
    }
}