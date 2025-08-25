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
                'po_number' => $this->po_number,
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

    public function save_stock_in_po($data)
{
    try {
        // --- Required common fields ---
        $po_number   = $data['po_number'];
        $supplier_id = $data['supplier_id'];
        $date_in     = $data['date_in'];
        $recieved_by = $data['recieved_by'];
        $items       = $data['items'];

        // Validate PO-level fields
        $header = [
            'po_number'   => $po_number,
            'supplier_id' => $supplier_id,
            'date_in'     => $date_in,
            'recieved_by' => $recieved_by,
        ];

        $emptyFields = array_filter($header, function ($value) {
            return $value === null || $value === '';
        });

        if (!empty($emptyFields)) {
            throw new Exception(MISSING_DETAILS, true);
        }

        if (empty($items) || !is_array($items)) {
            throw new Exception("No items provided for stock-in.", true);
        }

        // --- Begin transaction ---
        $this->db->trans_start();

        foreach ($items as $item) {
            $row = [
                'item_profile_id' => $item['item_id'],
                'supplier_id'     => $supplier_id,
                'po_number'       => $po_number,
                'quantity'        => $item['qty'],
                'date_in'         => $date_in,
                'recieved_by'     => $recieved_by,
                'date_created'    => date('Y-m-d H:i:s'),
                'branded'         => $item['branded'],
                'deleted'         => 0,
                'item_expiry_date'=> null, // optional if you don't have expiry yet
            ];

            $emptyItemFields = array_filter($row, function ($value) {
                return $value === null || $value === '';
            });

            // Don’t enforce expiry_date check since it can be null
            unset($emptyItemFields['item_expiry_date']);

            if (!empty($emptyItemFields)) {
                throw new Exception("Missing details for one of the items.", true);
            }

            $this->db->insert('tbl_inventory', $row);
        }

        // --- Complete transaction ---
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);
        } else {
            $this->db->trans_commit();
            return [
                'message'   => SAVED_SUCCESSFUL,
                'has_error' => false,
                'po_number' => $po_number
            ];
        }
    } catch (Exception $msg) {
        return [
            'message'   => $msg->getMessage(),
            'has_error' => true
        ];
    }
}
}
