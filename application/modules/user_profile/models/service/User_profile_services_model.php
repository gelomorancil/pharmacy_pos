<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_profile_services_model extends CI_Model
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
    public function authenticate_user()
    {
        try {
            $this->db->select('*');
            $this->db->from($this->Table->user);
            $this->db->where('Username', $this->uname);
            $query = $this->db->get()->row();
            
            // if($this->password == $query->Password){
            //    return array('has_error' => false, 'message' => 'Login Success');
            // }
            // else{
            //     throw new Exception(NOT_MATCH, true);
            // }
            
            if($query->Password !== sha1(password_generator($this->pass,$query->Locker)) ){
                throw new Exception(NOT_MATCH, true);
            }
            set_userdata(USER,(array)$query);

            return array('has_error' => false, 'error_message' => 'Password match');
        } catch (Exception $ex) {
            return array('error_message' => $ex->getMessage(), 'has_error' => true);
        }
    }

    public function change_pass(){
        try{     

            $Locker = locker();
            $Password = sha1(password_generator($this->new, $Locker));     
            
            $data = array(
                'Locker' => $Locker,
                'Password' => $Password
            );

            $this->db->trans_start();
            
            $this->db->where('Username', $this->uname);
            $this->db->update($this->Table->user,$data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {                
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);	
            }else{
                $this->db->trans_commit();
                return array('message'=>SAVED_SUCCESSFUL, 'has_error'=>false);
            }
        }
        catch(Exception$msg){
            return (array('message'=>$msg->getMessage(), 'has_error'=>true));
        }
    }
}