<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Change_password_model extends CI_Model
{
    public $Username;
    public $Password;
    public $Table;

    public function __construct()
    {
        parent::__construct();
        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function change_password()
    {
        // var_dump($this->username);
        // var_dump($this->current_password);
        // var_dump($this->new_password);

        try {

            if (empty($this->username) || empty($this->current_password)) {
                throw new Exception(REQUIRED_FIELD);
            }
            $this->db->select('*');
            $this->db->from($this->Table->user);
            $this->db->where('Username', $this->username);
            $query = $this->db->get()->row();

            if ($query->Active == 0) {
                return array('has_error' => true, 'message' => DISABLED_ACCOUNT);
            }
            if (empty($query)) {
                return array('has_error' => true, 'message' => NO_ACCOUNT);
            }
            if ($query->Password !== sha1(password_generator($this->current_password, $query->Locker))) {
                return array('has_error' => true, 'message' => NOT_MATCH);
            }
            // var_dump($query->Password);
            // var_dump(sha1(password_generator($this->new_password, $query->Locker)));


            $UID = auth_token();
            $new_password = $this->new_password;
            $Locker = locker();
            $Password = sha1(password_generator($new_password, $Locker));

            $data = array(
                'Locker' => $Locker,
                'Password' => $Password,
                'U_ID' => $UID,
                'Pass_change' => "1",
            );

            $this->db->trans_start();

            // Update where Username matches $this->Username
            $this->db->where('Username', $this->username);
            $this->db->update($this->Table->user, $data);

            $this->db->trans_complete();

            return array('has_error' => false, 'message' => 'Password Changed Successful');
        } catch (Exception $ex) {
            return array('error_message' => $ex->getMessage(), 'has_error' => true);
        }

    }

}