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

    public function get_expenses(){
        $this->db->select(
            'e.Branch as e_Branch,'.
            'e.ID,'.
            'e.Image,'.
            'e.Date,'.
            'e.Date,'.
            'e.Descr,'.
            'e.Actual_Money,'.
            'e.expense,'.
            'e.Balance,'.
            'e.Editted,'.
            'u.FName,'.
            'u.LName'

        );
        $this->db->from($this->Table->expenses.' e');
        $this->db->join($this->Table->user.' u', 'u.ID=e.Incharge','left');
        $this->db->where('e.Void', 0);

        if(@$this->d_from != NULL || @$this->d_to != NULL){
            $this->db->where('e.Date >=', @$this->d_from);
            $this->db->where('e.Date <=', @$this->d_to);

        } else{
            $this->db->where('e.Date', date('Y-m-d'));
        }

    //    if(!empty($this->session->Branch)){
    //         if($this->session->Role == "Admin"){
    //             $this->db->where('e.Branch', $this->session->Branch);
    //             // $this->db->where('e.Branch', "Bacolod");
    //         } else{
    //             $this->db->where('u.Branch', $this->session->Branch);
    //             $this->db->where('e.Incharge', $this->session->ID);
    //         }
    //     } 
        
    //   else {
    //         if(!empty($this->branch && $this->branch != "All")){
    //             $this->db->where('u.Branch', $this->branch);
    //         }
    //     }


        $query = $this->db->get()->result();
        return $query;
        //  echo json_encode($query);
    }

    public function get_expense_details(){
        $this->db->select('*');
        $this->db->from($this->Table->expenses);
        $this->db->where('ID', $this->exp_id);

        $query = $this->db->get()->row();
        return $query;
    }
}