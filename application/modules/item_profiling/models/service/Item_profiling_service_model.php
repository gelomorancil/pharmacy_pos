<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Item_profiling_service_model extends CI_Model
{
    public $ID;
    public $Table;

    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        $model_list = [
        ];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function save_item_profile()
    {
        try {
            $data = array(
                'item_id' => $this->item_id,
                'unit_id' => $this->unit_id,
                // 'unit_price' => $this->unit_price,
                'threshold' => $this->threshold,
            );
            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();

            $this->db->insert($this->Table->item_profile, $data);

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

    public function update_item_profile()
    {
        try {
            $data = array(
                'item_id' => $this->item_id,
                'unit_id' => $this->unit_id,
                // 'unit_price' => $this->unit_price,
                'threshold' => $this->threshold,
            );
            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();
            
            $this->db->where('id', $this->id);
            $this->db->update($this->Table->item_profile, $data);

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
