
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Quotation_model extends CI_Model
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

    public function insert_quotation($data)
    {
        $this->db->insert('tbl_quotation', $data);
        return $this->db->insert_id();
    }

    public function insert_items_batch($items)
    {
        if (empty($items)) return 0;
        $this->db->insert_batch('tbl_quotation_items', $items);
        return $this->db->affected_rows();
    }

    public function get_quotation_no()
    {
        $this->db->select('quotation_no');
        $this->db->from('tbl_quotation');
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $last_qn = $row->quotation_no;
            $new_qn = intval($last_qn) + 1;
            return str_pad($new_qn, 6, '0', STR_PAD_LEFT);
        } else {
            return '000000';
        }
    }

    public function get_quotations()
    {
        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->order_by('ID', 'DESC');
        $this->db->order_by('approved', '0');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_quotation_items($quotation_id)
    {
        $this->db->select('qi.*, i.item_name, qi.po_descr,u.unit_of_measure');
        $this->db->from('tbl_quotation_items qi');
        $this->db->join('tbl_items i', 'qi.item_ID = i.ID', 'left');
        $this->db->join('tbl_unit u', 'qi.unit_ID = u.ID', 'left');
        $this->db->where('qi.ID', $quotation_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_quotation($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($id)
    {
        // Delete quotation items first to avoid orphan rows
        $this->db->where('qo_ID', $id);
        $this->db->delete('tbl_quotation_items');

        // Delete quotation
        $this->db->where('ID', $id);
        return $this->db->delete('tbl_quotation');
    }
}