<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Top_items_model extends CI_Model
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

public function get_top_buyers()
{
    $this->db->select('
        SUM(pParent.total_amount) AS sale_quantity,
        buyers.name AS buyer_name,
        MAX(pParent.date_created) AS sale_date
    ');
    $this->db->from($this->Table->payment_parent . ' AS pParent');
    $this->db->join($this->Table->buyers . ' AS buyers', 'pParent.Buyer_ID = buyers.ID', 'left');

    // Only filter by date if not empty
    if (!empty($this->date)) {
        $date_parts = explode(' - ', $this->date);

        // Safely handle the case where only one date is passed
        if (count($date_parts) == 2) {
            $start_date = date('Y-m-d', strtotime($date_parts[0]));
            $end_date = date('Y-m-d', strtotime($date_parts[1]));

            // Use DATE() for accurate filtering
            $this->db->where('DATE(pParent.date_created) >=', $start_date);
            $this->db->where('DATE(pParent.date_created) <=', $end_date);
        }
    }

    $this->db->group_by('pParent.Buyer_ID');
    $this->db->order_by('sale_quantity', 'DESC');

    return $this->db->get()->result();
}

    public function get_top_items()
    {
        $this->db->select('
            SUM(pChild.quantity) AS sale_quantity,
            i.item_code,
            i.short_name,
            i.item_name,
            MAX(pParent.date_created) AS sale_date
        ');

        $this->db->from($this->Table->payment_child . ' AS pChild');
        $this->db->join($this->Table->payment_parent . ' AS pParent', 'pChild.payment_id = pParent.id', 'left');
        $this->db->join($this->Table->item_profile . ' AS ip', 'pChild.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');
        
        // Only filter by date if not empty
        if (!empty($this->date)) {
            $date_parts = explode(' - ', $this->date);

            // Safely handle the case where only one date is passed
            if (count($date_parts) == 2) {
                $start_date = date('Y-m-d', strtotime($date_parts[0]));
                $end_date = date('Y-m-d', strtotime($date_parts[1]));

                // Use DATE() for accurate filtering
                $this->db->where('DATE(pParent.date_created) >=', $start_date);
                $this->db->where('DATE(pParent.date_created) <=', $end_date);
            }
        }

        $this->db->group_by('pChild.item_profile_id');
        $this->db->order_by('sale_quantity', 'DESC');

        $query = $this->db->get()->result();
        return $query;
    }

}
