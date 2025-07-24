<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_model extends CI_Model
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

    public function get_inventory()
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock,
            ip.threshold,
            unit.unit_of_measure,
            items.item_name,
            items.short_name,
            items.item_code,
            items.description
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');

        // Subquery join to get sold quantities directly
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
          FROM {$this->Table->payment_child} 
          GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        // Group by essential fields only
        $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

        // Use HAVING clause to filter by threshold condition
        $this->db->having('current_stock <= (1.40 * ip.threshold)');
        $this->db->order_by('current_stock', 'ASC');

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
        $this->db->where("DATE_FORMAT(pParent.date_created, '%Y-%m') =", $this->date);

        $this->db->group_by('pChild.item_profile_id');
        $this->db->order_by('sale_quantity', 'DESC');
        $this->db->limit(10);

        $query = $this->db->get()->result();
        return $query;
    }

    public function get_monthly_sales()
    {
        // Create an array with all months initialized to zero
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $month_key = date("Y-m", strtotime($this->year . '-' . $i));
            $months[$month_key] = 0;
        }

        // Fetch the monthly sales data from the database
        $this->db->select(
            'DATE_FORMAT(pParent.date_created, "%Y-%m") AS month_year, ' .
            'SUM(pParent.total_amount) AS total'
        );
        $this->db->from($this->Table->payment_parent . ' pParent');
        $this->db->where('pParent.voided', 0);
        $this->db->where('YEAR(pParent.date_created)', $this->year);
        $this->db->group_by('month_year');
        $this->db->order_by('month_year', 'ASC');

        $query = $this->db->get()->result();

        // Replace zeros in the months array with actual totals from the database
        foreach ($query as $row) {
            $months[$row->month_year] = (float) $row->total;
        }

        // Format the results as an array of objects
        $results = [];
        foreach ($months as $month => $total) {
            $results[] = (object) ['month_year' => $month, 'total' => $total];
        }

        return $results;
    }


}
