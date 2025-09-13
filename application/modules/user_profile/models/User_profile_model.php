<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_profile_model extends CI_Model
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

    public function get_image()
    {
        try {
            $this->db->select('Image');
            $this->db->from($this->Table->u_image);
            $this->db->where('user_id', $this->session->ID);
            $query = $this->db->get()->row();

            return $query->Image;
        } catch (Exception $ex) {
            return null;
        }
    }
}
