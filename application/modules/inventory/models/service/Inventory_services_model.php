<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Inventory_services_model extends CI_Model
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
    public function save_stock_in()
    {
        try {

            $data = array(
                'item_profile_id' => $this->item,
                'supplier_id' => $this->supplier,

                'quantity' => $this->quantity,
                'date_in' => $this->date_in,
                'recieved_by' => $this->recieved_by,
                'date_created' => date('Y-m-d H:i:s'),
            );

            $emptyFields = array_filter($data, function ($value) {
                // Only check for null or empty string, not other falsy values like '0' or 0
                return $value === null || $value === '';
            });

            if (!empty($emptyFields)) {
                throw new Exception(MISSING_DETAILS, true);
            }


            $this->db->trans_start();

            $this->db->insert($this->Table->inventory, $data);

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
