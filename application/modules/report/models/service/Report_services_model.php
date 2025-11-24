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

   public function verify_void(){
        try{
            if (empty($this->username) || empty($this->password)) {
                throw new Exception(REQUIRED_FIELD);
            }
            $from = 'admin';
            $this->db->select('*');
            $this->db->from($this->Table->user);
            $this->db->where('Username', $this->username);
            $query = $this->db->get()->row();
            
            if($query->Active == 0){
                throw new Exception(DISABLED_ACCOUNT, true);
            }
            
            if(empty($query->Branch)){
                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
                    // It's a mobile device
                    throw new Exception(MOBILE_DEVICE);
                } 
            }

            if(empty($query)){
                throw new Exception(NO_ACCOUNT, true);
            }
            if($query->Password !== sha1(password_generator($this->password,$query->Locker)) ){
                throw new Exception(NOT_MATCH, true);
            }

            return array('has_error' => false, 'message' => 'User Verified');
        } catch (Exception $ex) {
        }catch(Exception$msg){
            return (array('message'=>$msg->getMessage(), 'has_error'=>true));
        }
    }
}