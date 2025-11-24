<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cashiering_service_model extends CI_Model
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

    // public function save_item_profile()
    // {
    //     try {
    //         $data = array(
    //             'item_id' => $this->item_id,
    //             'unit_id' => $this->unit_id,
    //             'unit_price' => $this->unit_price,
    //             'threshold' => $this->threshold,
    //         );
    //         $emptyFields = array_filter($data, function ($value) {
    //             // Only check for null or empty string, not other falsy values like '0' or 0
    //             return $value === null || $value === '';
    //         });

    //         if (!empty($emptyFields)) {
    //             throw new Exception(MISSING_DETAILS, true);
    //         }


    //         $this->db->trans_start();

    //         $this->db->insert($this->Table->item_profile, $data);

    //         $this->db->trans_complete();
    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             throw new Exception(ERROR_PROCESSING, true);
    //         } else {
    //             $this->db->trans_commit();
    //             return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
    //         }
    //     } catch (Exception $msg) {
    //         return (array('message' => $msg->getMessage(), 'has_error' => true));
    //     }
    // }

    // public function update_item_profile()
    // {
    //     try {
    //         $data = array(
    //             'item_id' => $this->item_id,
    //             'unit_id' => $this->unit_id,
    //             'unit_price' => $this->unit_price,
    //             'threshold' => $this->threshold,
    //         );
    //         $emptyFields = array_filter($data, function ($value) {
    //             // Only check for null or empty string, not other falsy values like '0' or 0
    //             return $value === null || $value === '';
    //         });

    //         if (!empty($emptyFields)) {
    //             throw new Exception(MISSING_DETAILS, true);
    //         }


    //         $this->db->trans_start();

    //         $this->db->where('id', $this->id);
    //         $this->db->update($this->Table->item_profile, $data);

    //         $this->db->trans_complete();
    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             throw new Exception(ERROR_PROCESSING, true);
    //         } else {
    //             $this->db->trans_commit();
    //             return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
    //         }
    //     } catch (Exception $msg) {
    //         return (array('message' => $msg->getMessage(), 'has_error' => true));
    //     }
    // }

    public function generateControlNumber()
    {
        $this->db->select('control_number');
        $this->db->from($this->Table->payment_parent);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $lastControlNumber = $query->row();

        if ($lastControlNumber) {
            $lastControlNumberValue = (int) $lastControlNumber->control_number;
            $newControlNumber = $lastControlNumberValue + 1;

            $control_number = str_pad($newControlNumber, 6, '0', STR_PAD_LEFT);
        } else {
            $control_number = '000001';
        }

        return $control_number;
    }

    public function process_payment()
    {   
       
        // var_dump(json_decode($this->input->post('itemsArray'), true));
        // var_dump($_FILES['image']);

        // For tbl_payment_parent
        $sub_total = $this->input->post('sub_total');
        $discount_amount = $this->input->post('discount_amount');
        $total_amount = $this->input->post('total_amount');
        $discount_type = $this->input->post('discount_type');
        $payment_type = $this->input->post('payment_type');
        $amount_rendered = $this->input->post('amount_rendered');
        $reference_number = $this->input->post('reference_number');
        $remarks = $this->input->post('remarks');
        $other_buyer = $this->input->post('other_buyer');
        $transaction_date = $this->input->post('transaction_date');
        
       
        $control_number = $this->generateControlNumber();

        try {

            if($this->input->post('buyer') == "null"){
                throw new Exception("Please select buyer.", true);

            } else {
                if ($this->input->post('buyer') == 0) {
                    $buyer = $this->save_new_buyer($other_buyer);
                } else {
                    $buyer = $this->input->post('buyer');
                }
            }

            $data = array(
                'sub_total' => $sub_total,
                'discount_amount' => $discount_amount,
                'total_amount' => $total_amount,
                'discount_type' => $discount_type,
                'payment_type' => $payment_type,
                'amount_rendered' => $amount_rendered,
                'reference_number' => $reference_number,
                'control_number' => $control_number,
                'remarks' => $remarks,
                'recieved_by' => $this->session->ID,
                'Buyer_id' => $buyer,
                'date_created' => $transaction_date
                // 'item_id' => $this->item_id,
            );

            $this->db->trans_start();

            $this->db->insert($this->Table->payment_parent, $data);
            $payment_id = $this->db->insert_id();

            $this->db->trans_complete();

            $this->insert_to_child_table($payment_id, json_decode($this->input->post('itemsArray'), true));

            $ls_items = $this->check_low_items(json_decode($this->input->post('itemsArray'), true));

            $this->add_to_purchase_order_item($ls_items);

            if ($payment_type == "ONLINE") {
                $this->add_image($payment_id, $_FILES['image']);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return array('message' => SAVED_SUCCESSFUL, 'has_error' => false, 'control_number' => $control_number);
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function insert_to_child_table($payment_id, $items_array)
    {
        $data = [];

        foreach ($items_array as $item) {
            $data[] = [
                'payment_id' => $payment_id,
                'item_profile_id' => $item['item_profile_id'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'discount' => $item['discount'],
                'total_price' => $item['total']
            ];
        }

        if ($this->db->insert_batch($this->Table->payment_child, $data)) {
            return [
                "message" => "Details saved successfully.",
                "has_error" => false
            ];
        } else {
            return [
                "message" => "Failed to save details.",
                "has_error" => true
            ];
        }
    }

    public function add_image($payment_id, $image_object)
    {
        try {
            $image = $image_object;

            $config['upload_path'] = FCPATH . 'assets/uploaded/proofs/';
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            // Uncomment the following line if you want to encrypt the filename
            // $config['encrypt_name'] = TRUE; 
            $config['max_size'] = 10240; // 10 MB in bytes

            $this->load->library('upload', $config);

            if (!$image) {
                throw new Exception('No image file provided.');
            }

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $imagePath = 'assets/uploaded/proofs/' . $uploadData['file_name'];

                $data = array(
                    'payment_id' => $payment_id,
                    'payment_proof' => $imagePath
                );

                $this->db->insert($this->Table->proof, $data);

                // return array('message' => 'Image added successfully.', 'has_error' => false);
            } else {
                // throw new Exception('Image upload failed: ' . $this->upload->display_errors('', ''));
            }
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'has_error' => true);
        }
    }

    public function save_new_buyer($x)
    {
        try {

            $data = array(
                'FName' => $x,
            );

            $this->db->trans_start();

            $this->db->insert($this->Table->buyers, $data);
            $buyer_last_id = $this->db->insert_id();

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);
            } else {
                $this->db->trans_commit();
                return $buyer_last_id;
            }
        } catch (Exception $msg) {
            return (array('message' => $msg->getMessage(), 'has_error' => true));
        }
    }

    public function check_low_items($items_arr)
    {
        $low_items = [];
        $this->db->select('
        inv.item_ID,
        (SUM(inv.qty) - COALESCE(MAX(sq.sold_quantity), 0)) AS current_stock,
    ');
        $this->db->from($this->Table->purchase_order_items . ' AS inv');
        $this->db->join($this->Table->purchase_order . ' AS po', 'inv.po_ID = po.ID', 'left');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_ID = ip.item_id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'inv.item_ID = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'inv.unit_ID = unit.id', 'left');

        // Subquery: one row per item_id (sold total)
        $this->db->join(
            "
        (SELECT ipj.item_id, SUM(pc.quantity) AS sold_quantity
           FROM {$this->Table->payment_child} pc
           JOIN {$this->Table->item_profile} ipj
             ON pc.item_profile_id = ipj.id
          GROUP BY ipj.item_id
        ) AS sq",
            'sq.item_id = inv.item_ID',
            'left'
        );

        $this->db->where('po.approved', 1);
        $this->db->group_by('inv.item_ID, ip.threshold, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');
        $this->db->having('current_stock <= ip.threshold');

        $q = $this->db->get()->result();

        $low_ids = array_map(function ($row) {
            return $row->item_ID;
        }, $q);

        foreach ($items_arr as $item) {
            $this->db->select('item_id');
            $this->db->from($this->Table->item_profile);
            $this->db->where('id', $item['item_profile_id']);
            $row = $this->db->get()->row();

            if ($row && in_array($row->item_id, $low_ids)) {
                // echo "Item {$row->item_id} is low stock!<br>";
                $low_items[] = $row->item_id;
            }
        }

        return $low_items;
    }

    public function add_to_purchase_order_item($items_arr)
    {
        if (empty($items_arr)) {
            return;
        }
        // get recent unapproved PO or create one
        $this->db->select('ID,po_num');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('approved', 0);
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);
        $po = $this->db->get()->row();

        if (!$po) {
            $last_po = $po->po_num;
            $new_po = intval($last_po) + 1;
            $data = array(
                'po_num' => str_pad($new_po, 6, '0', STR_PAD_LEFT),
            );
            $this->db->insert($this->Table->purchase_order, $data);
            $po_id = $this->db->insert_id();
        } else {
            $po_id = $po->ID;
        }
        // var_dump($po_id);

        foreach ($items_arr as $item_id) {
            // check if item already exists in purchase_order_items
            $this->db->select('ID')
                ->from($this->Table->purchase_order_items)
                ->where('po_ID', $po_id)
                ->where('item_ID', $item_id);
            $existing = $this->db->get()->row();
            // var_dump($existing);
            if ($existing) {
                continue; // skip if already exists
            }

            $this->db->select('*');
            $this->db->from($this->Table->item_profile);
            $this->db->where('item_id', $item_id);
            $this->db->order_by('ID', 'DESC');
            $ip_row = $this->db->get()->row();
            // insert item to purchase_order_items
            // var_dump($ip_row);
            $data = array(
                'item_ID' => $item_id,
                'unit_ID' => $ip_row->unit_id,
                'qty' => $ip_row->unit_id == 2 ? 1 : 100, // very bad practice
                'unit_price' => $ip_row->unit_price,
                'pcs' => $ip_row->unit_id == 2 ? 1 : 0,
                'po_ID' => $po_id,
                'po_descr' => '',
            );
            // var_dump($data);

            $this->db->insert($this->Table->purchase_order_items, $data);
        }
    }
}
