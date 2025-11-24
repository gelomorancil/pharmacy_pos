<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Expense_services_model extends CI_Model
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

    public function add_expense()
    {
        try {
            $date = $this->input->post('Date_added');
            $description = $this->input->post('Desc');
            $actualMoney = $this->input->post('Actual_money');
            $incharge = $this->input->post('Incharge');
            $actualExpenses = $this->input->post('Actual_Expenses');
            $balance = $this->input->post('Balance');
            $branch;
            
            if(empty($this->session->Branch)){
                if(empty($date) ||
                    empty($description)
                ){
                throw new Exception(EMPTY_FIELDS);
                }
            } 
            
            else if($this->session->Role == "Admin"){
                if(empty($date) ||
                empty($description) ||
                empty(@$_FILES['image'])
                ){
                throw new Exception(EMPTY_FIELDS);
                }
            }
            
            else{
                if(empty($date) ||
                empty($description) ||
                empty($actualMoney)
             ){
                 throw new Exception(EMPTY_FIELDS);
             }
            }
            
         

            if(empty($this->input->post('Branch'))){
                $branch = $this->session->Branch;
            } else{
                $branch = $this->input->post('Branch');
            }
            
            $image_2 = $this->input->post('image_2');

            // Get the uploaded image file
            $image = @$_FILES['image'];
            
            // Check if an image file has been uploaded
            if (!empty($image['name'])) {
                // Image upload configuration
                $config['upload_path'] = FCPATH . 'assets/uploaded/proofs/';
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                // $config['encrypt_name'] = TRUE; // Encrypt the filename. Activate if you want encrypted name for image files.
                $config['max_size'] = 10240; // 10 MB in bytes
            
                $this->load->library('upload', $config);
            
                // Upload the image
                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $imagePath = $uploadData['file_name']; // Image file name
                } else {
                    throw new Exception('Image upload failed: ' . $this->upload->display_errors('', ''));
                }
            } else {
                // No image uploaded, handle accordingly
                $imagePath = null; // Or set to a default value or handle it as per your requirement
            }

            $data = array(
                'Date' => $date,
                'Descr' => $description,
                'Actual_Money' => $actualMoney,
                'Incharge' => $this->session->ID,
                'expense' => $actualExpenses,
                'Balance' => $balance,
                'Branch' => $branch,
                'Image' => $imagePath ?: "",
                'Editted' => ($this->session->Role == 'Admin') ? 1 : 0
            );

            // Insert the data into the database
            $this->db->insert($this->Table->expenses, $data);

            return array('message' => 'Expense added successfully.', 'has_error' => false);
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'has_error' => true);
        }
    }

    public function edit_expense()
    {
        try {
            $date = $this->input->post('Date_added');
            $description = $this->input->post('Desc');
            $actualMoney = $this->input->post('Actual_money');
            $incharge = $this->input->post('Incharge');
            $actualExpenses = $this->input->post('Actual_Expenses');
            $balance = $this->input->post('Balance');
            $branch;
            if(empty($this->input->post('Branch'))){
                $branch = $this->session->Branch;
            } else{
                $branch = $this->input->post('Branch');
            }
            $ID = $this->input->post('ID');
            $image_2 = $this->input->post('image_2');

                // Get the uploaded image file
                $image = $_FILES['image'];
                
              
                // Image upload configuration
                $config['upload_path'] = FCPATH . 'assets/uploaded/proofs/'; 
                $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
                // $config['encrypt_name'] = TRUE; // Encrypt the filename. Activate if u want encrypted name for image files.
                $config['max_size'] = 10240; // 10 MB in bytes

                $this->load->library('upload', $config);

               // // Upload the image
                if ($this->upload->do_upload('image')) {
                
                    $uploadData = $this->upload->data();
                    $imagePath = $uploadData['file_name']; // Image file name
                } else {
                    throw new Exception('Image upload failed: ' . $this->upload->display_errors('', ''));
                }

                $data = array(
                    'Date' => $date,
                    'Descr' => $description,
                    'Actual_Money' => $actualMoney,
                    'Incharge' => $this->session->ID,
                    'expense' => $actualExpenses,
                    'Balance' => $balance,
                    'Branch' => $branch,
                    'Image' => $imagePath,
                    'Editted' => 1,
                );

            // Update the data into the database
            $this->db->where('ID', $ID);
            $this->db->update($this->Table->expenses, $data);

            return array('message' => 'Expense updated successfully.', 'has_error' => false);
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'has_error' => true);
        }
    }
    
     public function add_image()
    {
        try {
            $date = $this->input->post('Date_added');
            $description = $this->input->post('Desc');
            $branch;
            if(empty($this->input->post('Branch'))){
                $branch = $this->session->Branch;
            } else{
                $branch = $this->input->post('Branch');
            }
            $ID = $this->input->post('ID');
            $image_2 = $this->input->post('image_2');

                // Get the uploaded image file
                $image = $_FILES['image'];
                
              
                // Image upload configuration
                $config['upload_path'] = FCPATH . 'assets/uploaded/proofs/'; 
                $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
                // $config['encrypt_name'] = TRUE; // Encrypt the filename. Activate if u want encrypted name for image files.
                $config['max_size'] = 10240; // 10 MB in bytes

                $this->load->library('upload', $config);

               // // Upload the image
                if ($this->upload->do_upload('image')) {
                
                    $uploadData = $this->upload->data();
                    $imagePath = $image_2.", ".$uploadData['file_name']; // Image file name
                } else {
                    throw new Exception('Image upload failed: ' . $this->upload->display_errors('', ''));
                }

                $data = array(
                    'Image' => $imagePath 
                );

            // Update the data into the database
            $this->db->where('ID', $ID);
            $this->db->update($this->Table->expenses, $data);

            return array('message' => 'Image added successfully.', 'has_error' => false);
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'has_error' => true);
        }
    }

    public function void(){
        try{     
            $data = array(
                'Void' => 1
            );
    
            $this->db->trans_start();
                           
            $this->db->where('ID', $this->Expense_ID);
            $this->db->update($this->Table->expenses,$data);
    
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {                
                $this->db->trans_rollback();
                throw new Exception(ERROR_PROCESSING, true);	
            }else{
                $this->db->trans_commit();
                return array('message'=>VOID_EXP, 'has_error'=>false);
            }
        }
        catch(Exception$msg){
            return (array('message'=>$msg->getMessage(), 'has_error'=>true));
        }
    }
}
