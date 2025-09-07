<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Management_services_model extends CI_Model
{
    public $ID;
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

    public function save_list()
    {
        try {
            if (
                empty($this->item_name)
            ) {
                throw new Exception(MISSING_DETAILS, true);
            }

            $data = array(
                'item_name' => $this->item_name,
                'item_code' => $this->item_code,
                'short_name' => $this->short_name,
                'description' => $this->description,
                // 'item_expiry_date' => $this->item_expiry_date,
                'active' => $this->status,
            );

            $this->db->trans_start();

            $this->db->insert($this->Table->items, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function save_supplier()
    {
        try {

            $data = array(
                'supplier_name' => $this->supplier_name,
                'address' => $this->supplier_address,
                'contact_person' => $this->contact_person,
                'contact_number_1' => $this->contact_number_1,
                'contact_number_2' => $this->contact_number_2,
                'email' => $this->supplier_email,
                'active' => $this->supplier_status,
            );

            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();

            $this->db->insert($this->Table->supplier, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function update_item()
    {
        try {
            // var_dump($this->item_id);
            // Validate required fields
            if (empty($this->item_name)) {
                throw new Exception(MISSING_DETAILS, true);
            }
            if (empty($this->item_id)) {
                throw new Exception('Missing item ID for update.', true);
            }

            $data = array(
                'item_name' => $this->item_name,
                'item_code' => $this->item_code,
                'description' => $this->description,
                'short_name' => $this->short_name,
                // 'item_expiry_date' => $this->item_expiry_date,
                'active' => $this->status,
            );

            $this->db->trans_start();

            $this->db->where('id', $this->item_id);
            $result = $this->db->update($this->Table->items, $data);

            if (!$result) {
                throw new Exception('Database update failed.');
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return array('message' => $msg->getMessage(), 'has_error' => true);
        }
    }


    public function save_user()
    {
        try {
            if (
                empty($this->FName) &&
                empty($this->LName) &&
                empty($this->Username)
            ) {
                throw new Exception(MISSING_DETAILS, true);
            }

            $check = $this->check_user_exist();
            if (!empty($check)) {
                throw new Exception(DUPLICATE_USERNAME_FOUND, true);
            }

            $UID = auth_token();
            $default = "Password1234";
            $Locker = locker();
            $Password = sha1(password_generator($default, $Locker));

            $data = array(
                'Username' => $this->Username,
                'FName' => $this->FName,
                'LName' => $this->LName,
                'Role_ID' => $this->Role,
                'Role' => $this->Role_name,
                // 'Branch' => $this->Branch,
                'Locker' => $Locker,
                'Password' => $Password,
                'U_ID' => $UID,
            );

            $this->db->trans_start();

            $this->db->insert($this->Table->user, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    /** check username if it exist in the table */
    public function check_user_exist()
    {
        try {
            $this->db->select('ID');
            $this->db->where('Username', $this->Username);
            $query = $this->db->get($this->Table->user)->row();

            return $query;
        } catch (Exception $msg) {
            echo json_encode(array('error_message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function update_user()
    {
        try {
            if (
                empty($this->FName) &&
                empty($this->LName) &&
                empty($this->Username)
            ) {
                throw new Exception(MISSING_DETAILS, true);
            }

            $data = array(
                'Username' => $this->Username,
                'FName' => $this->FName,
                'LName' => $this->LName,
                'Role_ID' => $this->Role,
                // 'Branch' => $this->Branch,
                'Role' => $this->Role_name,
            );

            $this->db->trans_start();

            $this->db->where('ID', $this->user_id);
            $this->db->update($this->Table->user, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function delete_user()
    {
        try {
            $data = array(
                'Active' => '0',
            );

            $this->db->trans_start();

            $this->db->where('U_ID', $this->U_ID);
            $this->db->update($this->Table->user, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => DELETED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function delete_list()
    {
        try {
            $this->db->trans_start();

            $this->db->where('ID', $this->ID);
            $this->db->delete($this->Table->list);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => DELETED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function reset()
    {
        try {

            $default = "Password1234";
            $Locker = locker();
            $Password = sha1(password_generator($default, $Locker));

            $data = array(
                'Pass_change' => "0",
                'Locker' => $Locker,
                'Password' => $Password
            );

            $this->db->trans_start();

            $this->db->where('U_ID', $this->U_ID);
            $this->db->update($this->Table->user, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function update_supplier()
    {
        try {

            $data = array(
                'supplier_name' => $this->supplier_name,
                'address' => $this->supplier_address,
                'contact_person' => $this->contact_person,
                'contact_number_1' => $this->contact_number_1,
                'contact_number_2' => $this->contact_number_2,
                'email' => $this->supplier_email,
                'active' => $this->supplier_status,
            );

            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();

            $this->db->where('id', $this->supplier_id);
            $this->db->update($this->Table->supplier, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function save_unit()
    {
        try {

            $data = array(
                'unit_of_measure' => $this->unit,
            );

            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();

            $this->db->insert($this->Table->unit, $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function delete_unit()
    {
        try {

            $this->db->trans_start();

            $this->db->where('id', $this->unit_id);
            $this->db->delete($this->Table->unit);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function save_client()
{
    try {
        // map incoming model properties to DB columns
        $data = array(
            'name'     => $this->client_name,
            'affiliate'=> $this->client_company_aff,
            'cnum'     => $this->client_cn,
            'email'    => $this->client_email,
            'active'   => $this->client_status,
        );

        // required fields: name and cnum (affiliate/email are nullable in schema)
        $required = array(
            'name' => $data['name'],
            'cnum' => $data['cnum'],
        );

        $emptyFields = array_filter($required, function ($value) {
            // Only treat NULL or empty string as missing (not '0' or 0)
            return $value === null || $value === '';
        });

        if (!empty($emptyFields)) {
            throw new Exception(MISSING_DETAILS, true);
        }

        $this->db->trans_start();

        $this->db->insert($this->Table->client_list, $data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);
        } else {
            $this->db->trans_commit();
            return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
        }
    } catch (Exception $msg) {
        return (array('message' => $msg->getMessage(), 'has_error' => true));
    }
}

public function update_client()
{
    try {

        $data = array(
            'name'     => $this->client_name,
            'affiliate'=> $this->client_company_aff,
            'cnum'     => $this->client_cn,
            'email'    => $this->client_email,
            'active'   => $this->client_status,
        );

        // required fields: name and cnum
        $required = array(
            'name' => $data['name'],
            'cnum' => $data['cnum'],
        );

        $emptyFields = array_filter($required, function ($value) {
            return $value === null || $value === '';
        });

        if (!empty($emptyFields)) {
            throw new Exception(MISSING_DETAILS, true);
        }

        $this->db->trans_start();

        // use ID because CREATE TABLE shows `ID` as the PK
        $this->db->where('ID', $this->client_id);
        $this->db->update($this->Table->client_list, $data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);
        } else {
            $this->db->trans_commit();
            return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
        }
    } catch (Exception $msg) {
        return (array('message' => $msg->getMessage(), 'has_error' => true));
    }
}

}