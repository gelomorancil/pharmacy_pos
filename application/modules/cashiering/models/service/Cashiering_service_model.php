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

        $control_number = $this->generateControlNumber();

        try {
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
                // 'item_id' => $this->item_id,
            );

            $this->db->trans_start();

            $this->db->insert($this->Table->payment_parent, $data);
            $payment_id = $this->db->insert_id();

            $this->db->trans_complete();

            $this->insert_to_child_table($payment_id, json_decode($this->input->post('itemsArray'), true));
            
            if($payment_type == "ONLINE"){
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
}
