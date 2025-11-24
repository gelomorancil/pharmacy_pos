<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Report_model extends CI_Model
{
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

    public function get_sales()
    {
        $this->db->select('
            pParent.*,
            user.FName,
            user.LName,
            buyer.name AS buyer_name,
        ');
        $this->db->from($this->Table->payment_parent . ' AS pParent');
        $this->db->join($this->Table->user . ' AS user', 'pParent.recieved_by = user.id', 'left');
        $this->db->join($this->Table->buyers . ' AS buyer', 'pParent.Buyer_ID = buyer.ID', 'left');

        if ($this->date_from && $this->date_to) {
            $this->db->where('pParent.date_created >=', $this->date_from);
            $this->db->where('pParent.date_created <=', $this->date_to);
        }

        if ($this->load_type == "1") {
            $this->db->where('pParent.voided', 1);
        } else if ($this->load_type == "0") {
            $this->db->where('pParent.voided', 0);
        }


        $this->db->order_by('pParent.date_created', 'DESC');
        $parentQuery = $this->db->get();

        $sales = [];

        foreach ($parentQuery->result() as $parentRow) {
            $this->db->select('
                pChild.*,
                ip.item_id,
                item.item_name,
                item.item_code,
            ');
            $this->db->from($this->Table->payment_child . ' AS pChild');
            $this->db->join($this->Table->item_profile . ' AS ip', 'pChild.item_profile_id = ip.id', 'left');
            $this->db->join($this->Table->items . ' AS item', 'ip.item_id = item.id', 'left');
            $this->db->where('pChild.payment_id', $parentRow->id);
            $childQuery = $this->db->get();

            $parentRow->children = $childQuery->result();
        }

        return $parentQuery->result_array();
    }

    public function get_inventory()
    {
        $this->db->select('
            inv.*,
            s.supplier_name,
            i.item_name,
            i.item_code,
        ');
        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->supplier . ' AS s', 'inv.supplier_id = s.id', 'left');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');

        if ($this->date_from && $this->date_to) {
            $this->db->where('inv.date_created >=', $this->date_from);
            $this->db->where('inv.date_created <=', $this->date_to);
        }

        $this->db->where('inv.deleted', 0);
        $this->db->order_by('inv.date_created', 'DESC');

        $query = $this->db->get()->result();
        return $query;
    }




}