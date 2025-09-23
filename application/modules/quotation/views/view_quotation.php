<?php
main_header(['quotation']);
$session = (object) get_userdata(USER);
?>
<style>
    .bond-paper {
        width: 8.5in;
        min-height: 11in;
        padding: 30px;
        border: 1px solid #000;
        margin: auto;
    }

    h2,
    h3 {
        text-align: center;
        margin: 0;
    }

    .company-info {
        text-align: center;
        margin-bottom: 18px;
    }

    .quote-header {
        margin: 16px 0;
        text-align: right;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background: #f2f2f2;
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        margin: 6px 4px;
        border-radius: 4px;
        cursor: pointer;
        border: none;
        background: #007bff;
        color: #fff;
    }

    .btn.secondary {
        background: #6c757d;
    }

    .btn.danger {
        background: #dc3545;
    }

    .totals td {
        border: none;
        text-align: right;
        padding-right: 20px;
    }

    .footer {
        text-align: center;
        margin-top: 28px;
        font-size: 13px;
    }

    /* Simple modal */
    .modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 60;
    }

    .modal {
        display: none;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        z-index: 9999;
        width: 820px;
        max-width: 98%;
        border-radius: 6px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);
        height: 34%;
    }

    .modal-header,
    .modal-footer {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 12px 16px;
    }

    .modal-footer {
        border-top: 1px solid #eee;
        border-bottom: none;
        text-align: right;
    }

    .form-row {
        margin-bottom: 8px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .form-col {
        flex: 1;
        min-width: 0;
    }

    label {
        display: block;
        font-size: 13px;
        margin-bottom: 4px;
    }

    select,
    input[type=text],
    input[type=number],
    input[type=date],
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    textarea {
        resize: none;
        min-height: 56px;
    }

    .small {
        font-size: 13px;
        color: #666;
    }

    .actions {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-btn {
        cursor: pointer;
        padding: 6px 8px;
        border-radius: 4px;
        border: none;
    }po_ID

    .action-edit {
        background: #17a2b8;
        color: #fff;
    }

    .action-delete {
        background: #dc3545;
        color: #fff;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .bond-paper,
        .bond-paper * {
            visibility: visible;
        }

        .bond-paper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-12 text-center">
            <div style="margin-bottom:10px;">
                <button class="btn" id="print-quotation" onclick="print_q()">🖨️ Print Quotation</button>
            </div>
        </div>
    </div>
    <div class="bond-paper">
        <div class="company-info">
            <h2>ZANNA HEALTH AND WELLNESS PRODUCTS TRADING</h2>
            <p>Door #3 Integrated Sugarcane Growers of Negros Inc. Bldg., Mansilingan Bacolod City</p>
        </div>

        <h3>FOR QUOTATION</h3>
        <div class="quote-header">
            <p>No. <span id="quotation_no" style="color: red; font-weight: 600;"><?= $quotation->quotation_no ?></span>
            </p>
            <p>Date: <span id="current_date"><?= date('F j, Y', strtotime($quotation->date_added)); ?></p>
        </div>
        <div class="table-responsive">
            <table id="quotation_table">
                <thead>
                    <tr>
                        <th style="width:8%;">Qty</th>
                        <th style="width:26%;">Item</th>
                        <th style="width:10%;">Unit of Measure</th>
                        <th style="width:28%;">Item Description</th>
                        <th style="width:8%;">Pcs</th>
                        <th style="width:10%;">Unit Price</th>
                        <th style="width:10%;">Total</th>
                    </tr>
                </thead>
                <tbody id="table_rows">
                </tbody>
            </table>
        </div>

        <table class="totals">
            <tr>
                <td>
                    SUBTOTAL: ₱ <span id="subtotal_display"><?= $quotation->subtotal ?></span>
                    <input type="hidden" id="subtotal_value" value="0.00">
                </td>
            </tr>
            <tr>
                <td>
                    FREIGHT: ₱
                    <input type="number" id="freight_input" value="<?= $quotation->total ?>" step="0.01" min="0"
                        disabled style="width:120px; text-align:right;">
                    <span id="freight_display" style="display:none;">0.00</span>
                    <input type="hidden" id="freight_value" value="0.00">
                </td>
            </tr>
            <tr>
                <td>
                    TOTAL: ₱ <span id="total_display"><?= $quotation->total ?></span>
                    <input type="hidden" id="total_value" value="0.00">
                </td>
            </tr>
        </table>


        <div class="footer">
            <p>Bringing Health Closer to You</p>
            <p>Email: zannahealthandwellness@gmail.com | Contact No: 09988570191; 09292661935</p>
        </div>
    </div>
</section>


<?php
main_footer();
?>

<script>
    $(document).ready(function () {
        load_quotation();
    });

    function load_quotation() {
        $(document).gmLoadPage({
            url: base_url + 'Quotation/load_quotation_items?qID=<?= $quotation->ID ?>',
            load_on: '#table_rows'
        });
    }

    function print_q() {
            let printContents = document.querySelector('.bond-paper').innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = `
              <div class="container my-4">
                ${printContents}
              </div>
            `;

            window.print();

            document.body.innerHTML = originalContents;
            location.reload();
        }
</script>