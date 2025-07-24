<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Report_services_model extends CI_Model
{
    public $ID;
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
   
   public function void(){
    try{     
        $data = array(
            'voided' => 1
        );

        $this->db->trans_start();
                       
        $this->db->where('id', $this->pParentID);
        $this->db->update($this->Table->payment_parent,$data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {                
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);	
        }else{
            $this->db->trans_commit();
            return array('message'=>VOID, 'has_error'=>false);
        }
    }
    catch(Exception$msg){
        return (array('message'=>$msg->getMessage(), 'has_error'=>true));
    }
   }
}