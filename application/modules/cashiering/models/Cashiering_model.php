<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cashiering_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

       public function get_items()
    {
        $this->db->select('
            i.*,
            ip.unit_price        AS RP,
            ip.regular_stub      AS RS,
            ip.regular_box       AS RB,
            ip.Walkin_price      AS WP,
            ip.walkin_stub       AS WS,
            ip.walkin_box        AS WB,
            ip.Wholesale_price,
            ip.supplier_price,       
            ip.id                AS item_profile_id,
            u.unit_of_measure
        ');

        // 🔑 Items are the driving table
        $this->db->from($this->Table->items . ' i');

        // ✅ item_profile + supplier_price
        // ✅ BOTH depend on ACTIVE PO
        // ✅ supplier_price isolated per ITEM (1 to many like pricing)
        $this->db->join(
            "(
                SELECT 
                    ip.*,
                    poi.supplier_price
                FROM {$this->Table->item_profile} ip
                JOIN {$this->Table->purchase_order_items} poi
                    ON poi.po_ID = ip.po_ID
                JOIN (
                    SELECT
                        item_ID,
                        MIN(item_profile_id) AS item_profile_id
                    FROM (
                        SELECT 
                            ip2.ID AS item_profile_id,
                            ip2.item_ID,
                            (poi2.received_pcs - IFNULL(SUM(pc.quantity), 0)) AS remaining_qty
                        FROM {$this->Table->item_profile} ip2
                        JOIN {$this->Table->purchase_order_items} poi2
                            ON poi2.po_ID = ip2.po_ID
                        LEFT JOIN {$this->Table->payment_child} pc
                            ON pc.item_profile_id = ip2.ID
                        AND pc.voided = 0
                        GROUP BY ip2.ID
                        HAVING remaining_qty > 0
                    ) x
                    GROUP BY item_ID
                ) next_price
                    ON next_price.item_profile_id = ip.ID
                AND next_price.item_ID = ip.item_ID
            ) ip",
            'ip.item_ID = i.id',
            'left'
        );

        // unit still optional
        $this->db->join(
            $this->Table->unit . ' u',
            'ip.unit_id = u.id',
            'left'
        );

        $this->db->where('i.active', 1);

        // ✅ one row per item
        $this->db->group_by('i.id');

        $this->db->order_by('i.item_name', 'asc');

        $query = $this->db->get()->result();

        // attach current stock (0 if none)
        foreach ($query as $row) {
            $row->current_stock = $this->get_current_stock($row->id);
            // attach list of PO entries (price + remaining qty) for this item
            $row->pos = $this->get_item_pos($row->id);
        }

        return $query;
    }

//    public function get_items()
//     {
//         $this->db->select('
//             i.*,
//             ip.unit_price        AS RP,
//             ip.regular_stub      AS RS,
//             ip.regular_box       AS RB,
//             ip.Walkin_price      AS WP,
//             ip.walkin_stub       AS WS,
//             ip.walkin_box        AS WB,
//             ip.Wholesale_price,
//             ip.supplier_price,       
//             ip.id                AS item_profile_id,
//             u.unit_of_measure
//         ');

//         // 🔑 Items are the driving table
//         $this->db->from($this->Table->items . ' i');

//         // ✅ item_profile + supplier_price
//         // ✅ BOTH depend on ACTIVE PO
//         // ✅ supplier_price isolated per ITEM
//         $this->db->join(
//             "(SELECT 
//                 ip1.*,
//                 po1.supplier_price
//             FROM {$this->Table->item_profile} ip1
//             JOIN {$this->Table->purchase_order_items} po1
//                 ON po1.po_ID = ip1.po_ID
//             AND po1.item_ID = ip1.item_id
//             AND po1.active = 1
//             ) ip",
//             'ip.item_id = i.id',
//             'left'
//         );

//         // unit still optional
//         $this->db->join(
//             $this->Table->unit . ' u',
//             'ip.unit_id = u.id',
//             'left'
//         );

//         $this->db->where('i.active', 1);

//         // ✅ one row per item
//         $this->db->group_by('i.id');

//         $this->db->order_by('i.item_name', 'asc');

//         $query = $this->db->get()->result();

//         // attach current stock (0 if none)
//         foreach ($query as $row) {
//             $row->current_stock = $this->get_current_stock($row->id);
//         }

//         return $query;
//     }


    public function get_buyers()
    {
        $this->db->select('*');
        $this->db->from($this->Table->buyers);
        $this->db->where('name !=', 'WALK-IN');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get()->result();

        return $query;
    }

    /**
     * Return list of PO entries for a given item (price and remaining qty)
     * Each entry: { po_item_id, po_id, price, received_pcs, remaining_pcs }
     */
    public function get_item_pos($item_id)
    {
        $this->db->select('
            poi.ID AS po_item_id,
            poi.po_ID AS po_id,
            poi.unit_price AS price,
            poi.received_pcs,
            (poi.received_pcs - COALESCE(sold.sold_qty, 0)) AS remaining_pcs,
            po.date_approved
        ');
        $this->db->from($this->Table->purchase_order_items . ' AS poi');
        $this->db->join($this->Table->purchase_order . ' AS po', 'poi.po_ID = po.ID', 'left');

        // sold quantities per purchase_order_items (via item_profile.po_ID linking)
        $this->db->join("(
            SELECT ip.po_ID AS poi_id, SUM(pc.quantity) AS sold_qty
            FROM {$this->Table->payment_child} pc
            JOIN {$this->Table->item_profile} ip ON pc.item_profile_id = ip.ID
            JOIN {$this->Table->payment_parent} py ON pc.payment_id = py.id
            WHERE py.voided = 0
            GROUP BY ip.po_ID
        ) AS sold", 'sold.poi_id = poi.ID', 'left');

        $this->db->where('poi.item_ID', $item_id);
        $this->db->where('po.approved', 1);
        $this->db->order_by('po.date_approved', 'ASC');

        $rows = $this->db->get()->result();

        // map to simple arrays and ensure numeric types
        $pos = [];
        foreach ($rows as $r) {
            $pos[] = [
                'po_item_id' => $r->po_item_id,
                'po_id' => $r->po_id,
                'price' => floatval($r->price),
                'qty' => intval($r->remaining_pcs > 0 ? $r->remaining_pcs : 0),
            ];
        }
        return $pos;
    }

    // public function get_current_stock($item_id)
    // {
    //     $this->db->select('
    //         inv.item_ID,
    //         (SUM(inv.received_qty) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock
    //     ');
    //     $this->db->from($this->Table->purchase_order_items . ' AS inv');
    //     $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_ID = ip.id', 'left');
    //     $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');

    //     // Subquery for sold quantities
    //     $this->db->join(
    //         "(SELECT pc.item_profile_id, SUM(pc.quantity) AS sold_quantity 
    //         FROM {$this->Table->payment_child} pc
    //         JOIN {$this->Table->payment_parent} py
    //                 ON pc.payment_id = py.id
    //             WHERE py.date_created >= '2025-12-01'
    //         GROUP BY pc.item_profile_id) AS sold_quantities",
    //         'sold_quantities.item_profile_id = inv.item_ID',
    //         'left'
    //     );
        
        

    //     $this->db->where('items.id', $item_id);
    //     $this->db->group_by('inv.item_ID');

    //     $query = $this->db->get()->row();

    //     return $query ? $query->current_stock : 0; // return 0 if no stock found
    // }

   public function get_current_stock($item_id)
    {
        $this->db->select('
            inv.item_ID,
            (SUM(inv.received_pcs) - COALESCE(sq.sold_quantity, 0)) AS current_stock
        ');

        $this->db->from($this->Table->purchase_order_items . ' AS inv');
        $this->db->join($this->Table->purchase_order . ' AS po', 'inv.po_ID = po.ID', 'left');
        $this->db->join($this->Table->items . ' AS items', 'inv.item_ID = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'inv.unit_ID = unit.id', 'left');

        // ✅ Proper subquery (1 row per item_id)
        $this->db->join("
            (SELECT 
                ipj.item_id, 
                SUM(pc.quantity) AS sold_quantity
            FROM {$this->Table->payment_child} pc
            JOIN {$this->Table->item_profile} ipj
                ON pc.item_profile_id = ipj.id
            JOIN {$this->Table->payment_parent} py
                ON pc.payment_id = py.id
            WHERE py.date_created >= '2025-12-01'
            GROUP BY ipj.item_id
            ) AS sq",
            'sq.item_id = inv.item_ID',
            'left'
        );

        $this->db->where('po.approved', 1);
        $this->db->where('items.id', $item_id);
        $this->db->group_by('inv.item_ID');

        $query = $this->db->get()->row();

        return $query ? $query->current_stock : 0;
    }


    // public function get_items()
    // {
    //     $this->db->select('*');
    //     $this->db->where('Active', '1');
    //     $this->db->from($this->Table->items);
    //     $this->db->order_by('item_name', 'asc');
    //     $query = $this->db->get()->result();
    //     return $query;
    // }

    public function check_item_code()
    {
        $this->db->select('
        ip.*,

        u.unit_of_measure,

        i.item_name,
        i.item_code,
        i.description,
        i.short_name
        ');

        $this->db->from($this->Table->item_profile . ' AS ip');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');
        $this->db->join($this->Table->unit . ' AS u', 'ip.unit_id = u.id', 'left');

        $this->db->where('i.item_code', $this->item_code);

        $query = $this->db->get()->result();
        if (!empty($query)) {
            return (array('message' => "Item Code Verified", 'has_error' => false, 'query' => $query));
        } else {
            return (array('message' => "Item Code Not Found on System!", 'has_error' => true, 'query' => null));
        }
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

        // Custom Join to tbl_payment_child
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

        return $this->db->get()->result();
    }

    public function check_item_stock()
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');
        $this->db->where('items.item_code', $this->item_code);

        // Subquery to get sold quantities for each item profile
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->group_by('inv.item_profile_id');

        $current_stock_query = $this->db->get()->row();
        if (empty($this->quantity) || !is_numeric($this->quantity)) {
            return array('message' => "Missing Details. Input Quantity!", 'has_error' => true);
        } else if (!empty($this->current_quantity) && ($this->quantity + $this->current_quantity) > $current_stock_query->current_stock) {
            return array('message' => "Not Enough Stocks! only " . $current_stock_query->current_stock . " Stocks Left", 'has_error' => true);
        } else {
            return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
        }
    }

    public function check_stock_status()
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

        $this->db->where('items.item_code', $this->item_code);

        $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

        // Use HAVING clause to filter by threshold condition
        $this->db->having('current_stock <= ip.threshold');
        $this->db->order_by('current_stock', 'ASC');

        $query = $this->db->get()->result();
        return $query;
    }


    // FJ NEW FUNCTIONS
    public function get_price_tiers($item_id)
    {
        $this->db->select('
            ip.id AS profile_id,
            ip.unit_price AS price,
            ip.po_ID,
            COALESCE(poi.received_pcs, 0) AS received_pcs,
            po.date_approved
        ');
        $this->db->from($this->Table->item_profile . ' ip');
        $this->db->join($this->Table->purchase_order . ' po', 'ip.po_ID = po.ID', 'left');
        $this->db->join($this->Table->purchase_order_items . ' poi', 'po.ID = poi.po_ID AND poi.item_ID = ip.item_ID', 'left');
        
        $this->db->where('ip.item_ID', $item_id);
        $this->db->order_by('po.date_approved', 'ASC');

        $query = $this->db->get();
        if ($query === FALSE) {
            return array();
        }
        
        $rows = $query->result();

        // Map to simple array
        $tiers = [];
        foreach ($rows as $r) {
            $tiers[] = [
                'profile_id' => intval($r->profile_id),
                'price' => floatval($r->price),
                'qty' => intval($r->received_pcs > 0 ? $r->received_pcs : 0),
            ];
        }
        return $tiers;
    }

    public function calculate_effective_price($item_id, $quantity, $base_price, $cart_qty = 0)
    {
        // Get total qty used in previous orders (non-voided)
        $this->db->select('SUM(pc.quantity) AS total_used');
        $this->db->from($this->Table->payment_child . ' pc');
        $this->db->join($this->Table->item_profile . ' ip', 'pc.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->payment_parent . ' pp', 'pc.payment_id = pp.id', 'left');
        $this->db->where('ip.item_ID', $item_id);
        $this->db->where('pp.voided', 0);
        $used_result = $this->db->get()->row();
        $total_used = $used_result ? (int)$used_result->total_used : 0;

        // Get price tiers (PO qty + item_profile prices)
        $tiers = $this->get_price_tiers($item_id);
        
        if (empty($tiers)) {
            return $base_price;
        }

        // Track cumulative quantity across all tiers
        $tier_start = 0;
        $applicable_price = $base_price;

        // Calculate what the total quantity will be after adding the new items
        $total_after_add = $total_used + $cart_qty + $quantity;

        // Find which tier the last item falls into
        foreach ($tiers as $tier) {
            $tier_qty = $tier['qty'];       // received_pcs for this PO
            $tier_price = $tier['price'];   // price for this tier
            $tier_end = $tier_start + $tier_qty;

            // Check if our new total quantity intersects with this tier
            if ($total_after_add > $tier_start && $total_after_add <= $tier_end) {
                // The new item(s) fall within or end in this tier
                $applicable_price = $tier_price;
                break;
            }

            $tier_start = $tier_end;
        }

        return floatval($applicable_price);
    }

    public function get_available_stock($item_id, $cart_qty = 0)
    {
        $this->db->select('SUM(poi.received_pcs) AS total_received');
        $this->db->from($this->Table->purchase_order_items . ' poi');
        $this->db->join($this->Table->purchase_order . ' po', 'poi.po_ID = po.ID', 'left');
        $this->db->where('poi.item_ID', $item_id);
        $this->db->where('po.approved', 1);
        $received = $this->db->get()->row();
        $total_received = $received ? (int)$received->total_received : 0;

        // Get total qty used in non-voided orders
        $this->db->select('SUM(pc.quantity) AS total_used');
        $this->db->from($this->Table->payment_child . ' pc');
        $this->db->join($this->Table->item_profile . ' ip', 'pc.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->payment_parent . ' pp', 'pc.payment_id = pp.id', 'left');
        $this->db->where('ip.item_ID', $item_id);
        $this->db->where('pp.voided', 0);
        $used = $this->db->get()->row();
        $total_used = $used ? (int)$used->total_used : 0;

        // Available = received - used - current_cart_qty
        $available = $total_received - $total_used - $cart_qty;
        return max(0, $available); // Never return negative
    }

}