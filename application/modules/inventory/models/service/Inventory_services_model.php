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

    public function save_stock_in_po()
{
    try {

        $purchaseOrderData = array(
            'supplier_id' => $this->supplier,
            'po_num' => $this->po_number,
            'date_ordered' => $this->date_in,
            'received_by' => $this->recieved_by,
            'date_added' => date('Y-m-d H:i:s'),
        );

        $emptyFields = array_filter($purchaseOrderData, function ($value) {
            return $value === null || $value === '';
        });
        
        if (!empty($emptyFields)) {
            throw new Exception(MISSING_DETAILS, true);
        }

        
        $this->db->trans_start();
        // Insert Purchase Order
        $this->db->insert('tbl_purchase_order', $purchaseOrderData);
        $po_id = $this->db->insert_id();

        if (!$po_id) {
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);
        }

        foreach($this->items as $val){
            $itemRow = [
                'date_expiry' => $val['date_expiry'],
                'item_ID'     => $val['item_id'],
                'unit_price'  => $val['unit_price'],
                'unit_ID'     => $val['unit_id'],
                'threshold'   => $val['threshold'],
                'qty'   => $val['qty'],
                'po_ID'    => $po_id,
            ];
    
            $emptyItemFields = array_filter($itemRow, function ($value) {
                return $value === null || $value === '';
            });
    
            if (!empty($emptyItemFields)) {
                $this->db->trans_rollback();
                throw new Exception(MISSING_DETAILS, true);
            }
    
            $this->db->insert('tbl_purchase_order_items', $itemRow);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception(ERROR_PROCESSING, true);
        } else {
            $this->db->trans_commit();
            return [
                'message'   => SAVED_SUCCESSFUL,
                'has_error' => false,
                'po_id'     => $po_id
            ];
        }
    } catch (Exception $msg) {
        return [
            'message'   => $msg->getMessage(),
            'has_error' => true
        ];
    }
}

public function update_po_with_items($data)
{
    $this->db->trans_start();

    // Get PO ID from number
    $po = $this->db->select('ID')
                   ->from($this->Table->purchase_order)
                   ->where('po_num', $data['po_number'])
                   ->get()
                   ->row();

    if (!$po) {
        throw new Exception("PO not found");
    }
    $poID = $po->ID;

    // Update PO header if needed
    $updateData = [
        'date_ordered' => $data['date_in'],
        'supplier_ID'  => $data['supplier_id'],
        // 'received_by'  => $data['received_by']
    ];
    $this->db->where('ID', $poID)->update($this->Table->purchase_order, $updateData);

    // Delete old items
    $this->db->where('po_ID', $poID)->delete($this->Table->purchase_order_items);

    // Insert new items
    foreach ($data['items'] as $item) {
        $itemRow = [
            'po_ID'       => $poID,
            'date_expiry' => $item['date_expiry'],
            'unit_price'  => $item['unit_price'],
            'threshold'   => $item['threshold'],
            'unit_ID'     => $item['unit_id'], // if you need mapping
            'item_ID'     => $item['item_id']
        ];
        $this->db->insert($this->Table->purchase_order_items, $itemRow);
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        throw new Exception("Error updating purchase order");
    }
}

    public function remove_po_item(){
        $this->db->where('ID', $this->id)->delete($this->Table->purchase_order_items);
        return [
            'message'   => SAVED_SUCCESSFUL,
            'has_error' => false,
        ];
    }

    public function approve_po(){
        $this->db->where('po_num', $this->po_number)
                 ->update($this->Table->purchase_order, ['approved' => 1]);
        return [
            'message'   => SAVED_SUCCESSFUL,
            'has_error' => false,
        ];
    }

    public function delete_po(){
        $this->db->where('po_num', $this->po_number)
                 ->delete($this->Table->purchase_order);
        return [
            'message'   => SAVED_SUCCESSFUL,
            'has_error' => false,
        ];
    }
}
