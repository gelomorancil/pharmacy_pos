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
    }

    .action-edit {
        background: #17a2b8;
        color: #fff;
    }

    .action-delete {
        background: #dc3545;
        color: #fff;
    }

    @media print {
/* 
        .btn,
        .modal,
        .modal-backdrop {
            display: none !important;
        } */

        /* td {
            border: 1px solid #000 !important;
        } */

        /* #freight_input {
            display: none !important;
        }

        #freight_display {
            display: inline !important;
        } */

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

        button {
            display: none !important;
        }
    }
</style>

<section class="content">
    <div class="bond-paper">
        <div class="company-info">
            <h2>ZANNA HEALTH AND WELLNESS PRODUCTS TRADING</h2>
            <p>Door #3 Integrated Sugarcane Growers of Negros Inc. Bldg., Mansilingan Bacolod City</p>
        </div>

        <h3>FOR QUOTATION</h3>
        <div class="quote-header">
            <p>No. <span id="quotation_no" style="color: red; font-weight: 600;"><?= $quotation_no ?></span></p>
            <p>Date: <span id="current_date"><?= date('F j, Y'); ?></p>
        </div>
        <div style="margin-bottom:10px;">
            <button id="openModalBtn" class="btn">➕ Add Item</button>
            <button class="btn" id="savePrintBtn">🖨️ Save & Print Quotation</button>
        </div>
        <div class="table-responsive">
            <table id="quotation_table">
                <thead>
                    <tr>
                        <!-- headers adapted to show the key visible columns -->
                        <th style="width:8%;">Qty</th>
                        <th style="width:23%;">Item</th>
                        <th style="width:10%;">Unit of Measure</th>
                        <th style="width:25%;">Item Description</th>
                        <th style="width:8%;">Pcs</th>
                        <th style="width:10%;">Unit Price</th>
                        <th style="width:10%;">Total</th>
                        <th style="width:6%;">Action</th>
                    </tr>
                </thead>
                <tbody id="table_rows">
                    <!-- appended rows will go here -->
                </tbody>
            </table>
        </div>

        <table class="totals">
            <tr>
                <td>
                    SUBTOTAL: ₱ <span id="subtotal_display">0.00</span>
                    <input type="hidden" id="subtotal_value" value="0.00">
                </td>
            </tr>
            <tr>
                <td>
                    FREIGHT: ₱
                    <input type="number" id="freight_input" value="0.00" step="0.01" min="0"
                        style="width:120px; text-align:right;">
                    <span id="freight_display" style="display:none;">0.00</span>
                    <input type="hidden" id="freight_value" value="0.00">
                </td>
            </tr>
            <tr>
                <td>
                    TOTAL: ₱ <span id="total_display">0.00</span>
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

<div class="modal-backdrop" id="modalBackdrop"></div>

<div class="modal" id="itemModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-header">
        <strong id="modalTitle">Add item to quotation</strong>
        <button id="modalClose" class="btn secondary" style="background:#6c757d;">✕</button>
    </div>

    <div class="modal-body">
        <!-- Row 1: Select Item / UOM / Quantity / Pcs / Unit Price -->
        <div class="form-row">
            <div class="form-col" style="flex:2;">
                <label for="modal_select_item">Select Item:</label>
                <select id="modal_select_item" onchange="fill_in_item(this)">
                    <option value="" selected disabled>-- Select item --</option>
                    <?php
                    foreach ($items_profiles as $value) {
                        ?>
                        <option value="<?= $value->id ?>"> <?= $value->item_name ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-col" style="flex:1;">
                <label for="modal_specs">Unit of Measure:</label>
                <select id="modal_specs" disabled>
                    <?php
                    foreach ($units as $value) {
                        ?>
                        <option value="<?= $value->id ?>"><?= $value->unit_of_measure ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-col" style="flex:1;">
                <label for="modal_qty">Quantity:</label>
                <input id="modal_qty" type="number" min="0" step="1" placeholder="Enter quantity" value="1" />
            </div>

            <div class="form-col" style="flex:1;">
                <label for="modal_pcs">Pcs:</label>
                <input id="modal_pcs" type="number" min="0" step="1" placeholder="Enter pcs" disabled />
            </div>

            <div class="form-col" style="flex:1;">
                <label for="modal_unit">Unit Price:</label>
                <!-- kept id modal_unit for backward compatibility -->
                <input id="modal_unit" type="number" min="0" step="0.01" placeholder="Enter Unit Price" value="0" />
            </div>
        </div>

        <!-- Row 2: Item Description / Date Expiry -->
        <div class="form-row">
            <div class="form-col" style="flex:3;">
                <label for="modal_desc">Item Description:</label>
                <!-- kept id modal_desc for backward compatibility -->
                <input id="modal_desc" type="text" placeholder="Item Description" />
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button id="modalAdd" class="btn">Add item</button>
        <button id="modalCancel" class="btn secondary">Cancel</button>
    </div>
</div>

<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/quotation/quotation.js"></script>

<script>
    $(function () {
        function escapeHtml(str) { if (str === null || str === undefined) return ''; return String(str).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
        function showModal() { $('#modalBackdrop').fadeIn(150); $('#itemModal').fadeIn(180); $('#modal_select_item').focus(); }
        function hideModal() { $('#itemModal').fadeOut(120); $('#modalBackdrop').fadeOut(120); clearModal(); editingTempId = null; }
        function clearModal() { $('#modal_select_item').val(''); $('#modal_specs').val('box'); $('#modal_qty').val(1); $('#modal_pcs').val(''); $('#modal_unit').val('0.00'); $('#modal_desc').val(''); $('#modal_expiry').val(''); $('#modalTitle').text('Add item to quotation'); }
        function recalcLineTotal() { let q = parseFloat($('#modal_qty').val()) || 0; let u = parseFloat($('#modal_unit').val()) || 0; $('#modal_total_hidden').val((q * u).toFixed(2)); } // kept for compatibility if needed

        let editingTempId = null;

        $('#openModalBtn').on('click', function () { clearModal(); showModal(); });
        $('#modalClose, #modalCancel').on('click', hideModal);
        $('#modalBackdrop').on('click', hideModal);
        $(document).on('keydown', function (e) { if (e.key === 'Escape') hideModal(); });
        $('#modal_qty, #modal_unit').on('input', recalcLineTotal);

        // Add or update item (keeps append feature and stores data-item-id)
        $('#modalAdd').on('click', function () {
            let itemId = $('#modal_select_item').val() || '';
            let itemName = $('#modal_select_item option:selected').text() || '';
            let uom = $('#modal_specs').val() || '';
            let uom_display = $('#modal_specs option:selected').text() || '';
            let qty = parseInt($('#modal_qty').val(), 10) || 0;
            let pcs = parseInt($('#modal_pcs').val(), 10) || 0;
            let unit = parseFloat($('#modal_unit').val()) || 0;
            let desc = $('#modal_desc').val().trim() || '';
            let expiry = '';
            let total = parseFloat((qty * unit).toFixed(2)) || 0.00;

            recalcTotals();

            if (!itemId) { alert('Please select an item.'); $('#modal_select_item').focus(); return; }
            if (qty <= 0) { alert('Quantity must be at least 1.'); $('#modal_qty').focus(); return; }

            if (editingTempId) {
                // update existing row
                let $tr = $('#table_rows').find('tr[data-temp-id="' + editingTempId + '"]');
                if ($tr.length) {
                    $tr.attr('data-item-id', itemId)
                        .attr('data-item-name', itemName)
                        .attr('data-uom', uom)
                        .attr('data-desc', desc)
                        .attr('data-qty', qty)
                        .attr('data-pcs', pcs)
                        .attr('data-unit', unit.toFixed(2))
                        .attr('data-total', total.toFixed(2))
                        .attr('data-expiry', expiry);

                    $tr.find('.display-item').text(itemName);
                    $tr.find('.display-uom').text(uom);
                    $tr.find('.display-desc').text(desc);
                    $tr.find('.display-qty').text(qty);
                    $tr.find('.display-pcs').text(pcs);
                    $tr.find('.display-unit').text(unit.toFixed(2));
                    $tr.find('.display-total').text(total.toFixed(2));
                    $tr.find('.display-expiry').text(expiry);
                }
            } else {
                // append new row
                let rowIndex = $('#table_rows tr').length + 1;
                let tempId = 't' + Date.now() + Math.floor(Math.random() * 1000);
                let $tr = $('<tr>').attr({
                    'data-temp-id': tempId,
                    'data-item-id': itemId,
                    'data-item-name': itemName,
                    'data-uom': uom,
                    'data-desc': desc,
                    'data-qty': qty,
                    'data-pcs': pcs,
                    'data-unit': unit.toFixed(2),
                    'data-total': total.toFixed(2),
                    'data-expiry': expiry
                });

                $tr.append($('<td>').html(
                    `<span class="display-qty">${qty}</span>
         <input type="hidden" name="items[${rowIndex}][qty]" value="${qty}" class="i_qty_${rowIndex}">`
                ));
                $tr.append($('<td>').html(
                    `<span class="display-item">${escapeHtml(itemName)}</span>
         <input type="hidden" name="items[${rowIndex}][item_id]" value="${escapeHtml(itemId)}">`
                ));
                $tr.append($('<td>').html(
                    `<span class="display-uom">${escapeHtml(uom_display)}</span>
         <input type="hidden" name="items[${rowIndex}][uom]" value="${escapeHtml(uom)}">`
                ));
                $tr.append($('<td>').html(
                    `<span class="display-desc">${escapeHtml(desc)}</span>
         <input type="hidden" name="items[${rowIndex}][desc]" value="${escapeHtml(desc)}">`
                ));
                $tr.append($('<td>').html(
            `<span class="display-pcs">${pcs == 0 ? qty : pcs}</span>
            <input type="hidden" name="items[${rowIndex}][pcs]" value="${pcs}" class="i_pcs_${rowIndex}">`
                ));
                $tr.append($('<td>').html(
                    `<span class="display-unit">${unit.toFixed(2)}</span>
         <input type="hidden" name="items[${rowIndex}][unit]" value="${unit.toFixed(2)}" class="i_unit_${rowIndex}">`
                ));
                $tr.append($('<td>').html(
                    `<span class="display-total">${total.toFixed(2)}</span>
         <input type="hidden" name="items[${rowIndex}][total]" value="${total.toFixed(2)}" class="i_total_${rowIndex}">`
                ));
                $tr.append($('<td>').html(`
        <div class="actions">
          <button class="action-btn action-edit" title="Edit item" data-temp-id="${tempId}">Edit</button>
          <button class="action-btn action-delete" title="Delete item" data-temp-id="${tempId}">Del</button>
        </div>
      `));

                $('#table_rows').append($tr);
            }

            hideModal();
        });

        // delete
        $('#table_rows').on('click', '.action-delete', function () {
            let tid = $(this).attr('data-temp-id');
            if (!tid) return;
            if (!confirm('Remove this item from the quotation?')) return;
            recalcTotals();
            $('#table_rows').find('tr[data-temp-id="' + tid + '"]').remove();
        });

        // edit: populate modal with row data
        $('#table_rows').on('click', '.action-edit', function () {
            let tid = $(this).attr('data-temp-id');
            if (!tid) return;
            let $tr = $('#table_rows').find('tr[data-temp-id="' + tid + '"]');
            if (!$tr.length) return;
            recalcTotals();
            $('#modal_select_item').val($tr.attr('data-item-id'));
            $('#modal_specs').val($tr.attr('data-uom'));
            $('#modal_qty').val($tr.attr('data-qty'));
            $('#modal_pcs').val($tr.attr('data-pcs'));
            $('#modal_unit').val($tr.attr('data-unit'));
            $('#modal_desc').val($tr.attr('data-desc'));
            $('#modal_expiry').val($tr.attr('data-expiry'));

            editingTempId = tid;
            $('#modalTitle').text('Edit item');
            showModal();
        });

        // quick dblclick to edit
        $('#table_rows').on('dblclick', 'tr', function () { let tid = $(this).attr('data-temp-id'); if (tid) $(this).find('.action-edit').trigger('click'); });

        function collectQuotationPayload() {
            const items = [];
            $('#table_rows tr').each(function () {
                const $tr = $(this);
                // read from data-* attributes (fallback to visible spans)
                const item_id = $tr.attr('data-item-id') || $tr.find('input[name$="[item_id]"]').val() || '';
                const item_name = $tr.attr('data-item-name') || $tr.find('.display-item').text().trim() || '';
                const uom = $tr.attr('data-uom') || $tr.find('.display-uom').text().trim() || '';
                const desc = $tr.attr('data-desc') || $tr.find('.display-desc').text().trim() || '';
                const qty = parseInt($tr.attr('data-qty') || $tr.find('.display-qty').text()) || 0;
                const pcs = parseInt($tr.attr('data-pcs') || $tr.find('.display-pcs').text()) || 0;
                const unit = parseFloat($tr.attr('data-unit') || $tr.find('.display-unit').text()) || 0;
                const total = parseFloat($tr.attr('data-total') || $tr.find('.display-total').text()) || (qty * unit) || 0;
                const expiry = $tr.attr('data-expiry') || $tr.find('.display-expiry').text().trim() || '';

                items.push({
                    item_id: item_id,
                    item_name: item_name,
                    uom: uom,
                    desc: desc,
                    qty: qty,
                    pcs: pcs,
                    unit: unit,
                    total: total,
                    expiry: expiry
                });
            });

            const subtotal = items.reduce((s, it) => s + (parseFloat(it.total) || 0), 0);
            // optional inputs on page; if missing, defaults
            const freight = parseFloat($('#freight_input').val && $('#freight_input').val() ? $('#freight_input').val() : 0) || 0;
            const total = parseFloat((subtotal + freight).toFixed(2));

            // optional: allow user-specified quotation_no
            const quotation_no = $('#quotation_no').text().trim();

            return { quotation_no: quotation_no, subtotal: subtotal, freight: freight, total: total, items: items };
        }

        function saveQuotationAndPrint() {
            if (!confirm('Are you sure you want to save and print this quotation? Please double-check.')) return;

            const payload = collectQuotationPayload();

            // disable UI while saving
            $('.btn, #openModalBtn').prop('disabled', true);

            $.ajax({
                url: base_url + '/quotation/save', // adjust this URL to your actual controller route if different
                method: 'POST',
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (resp) {
                    if (resp && resp.success) {
                        // optional: store returned quotation id on page for later use
                        $('body').attr('data-saved-quotation-id', resp.quotation_id || '');
                        $('body').attr('data-saved-quotation-no', resp.quotation_no || '');
                        // success - print then reload to restore the UI and clear temp rows if you want
                        try {
                            printOnlyBondPaper()
                        } catch (e) {
                            console.warn('print failed', e);
                        }
                        // reload the page to reset UI (keeps it simple)
                        window.location.reload(true);
                    } else {
                        const msg = (resp && resp.message) ? resp.message : 'Save failed';
                        alert('Save failed: ' + msg);
                        $('.btn, #openModalBtn').prop('disabled', false);
                    }
                },
                error: function (jqXHR, textStatus, err) {
                    console.error('save error', textStatus, err);
                    alert('Server error while saving quotation. Check console for details.');
                    $('.btn, #openModalBtn').prop('disabled', false);
                }
            });
        }

        // function printOnlyBondPaper() {
        //     // 1) Clone the bond-paper (work on a copy)
        //     const $clone = $('.bond-paper').first().clone();

        //     // 2) Remove UI elements from the clone
        //     // $clone.find('#openModalBtn, #savePrintBtn, .modal, .modal-backdrop, .action-btn, .btn').remove();

        //     // 3) Remove action column (header + last cell in each row) from clone
        //     $clone.find('#quotation_table th:last-child').remove();
        //     $clone.find('#quotation_table tbody tr').each(function () {
        //         $(this).find('td:last-child').remove();
        //     });

        //     // // 4) For each table cell: choose a single canonical value and replace the cell with that value
        //     // $clone.find('#quotation_table tbody tr').each(function () {
        //     //     $(this).find('td').each(function () {
        //     //         const $td = $(this);

        //     //         // Prefer visible display elements (classes like .display-*)
        //     //         let $display = $td.find('[class*="display-"]').filter(function () {
        //     //             return $(this).text().trim() !== '';
        //     //         }).first();

        //     //         let text = '';

        //     //         if ($display && $display.length) {
        //     //             text = $display.text().trim();
        //     //         } else {
        //     //             // then prefer visible inputs/selects/textarea (not hidden)
        //     //             let $valEl = $td.find('input:not([type="hidden"]), select, textarea').first();
        //     //             if ($valEl && $valEl.length) {
        //     //                 text = $valEl.val() != null ? String($valEl.val()).trim() : '';
        //     //             } else {
        //     //                 // then check for hidden input (we use hidden inputs for server payload)
        //     //                 let $hidden = $td.find('input[type="hidden"]').first();
        //     //                 if ($hidden && $hidden.length) {
        //     //                     text = $hidden.val() != null ? String($hidden.val()).trim() : '';
        //     //                 } else {
        //     //                     // fallback to raw td text (trimmed)
        //     //                     text = $td.text().trim();
        //     //                 }
        //     //             }
        //     //         }

        //     //         // Replace the cell content with a single text node (no duplicates)
        //     //         $td.empty().text(text);
        //     //     });
        //     // });

        //     // // 5) Convert any remaining inputs/selects/textarea anywhere in the clone (e.g., totals/freight)
        //     // $clone.find('input, select, textarea').each(function () {
        //     //     const $el = $(this);
        //     //     const val = $el.val() != null ? String($el.val()).trim() : '';
        //     //     $el.replaceWith($('<span>').text(val));
        //     // });

        //     // // 6) Remove any leftover hidden inputs or form attributes to avoid leaking names
        //     // $clone.find('input[type="hidden"]').remove();
        //     // $clone.find('[name]').removeAttr('name');

        //     // // 7) Prepare print markup (replace body with cleaned clone)
        //     // const printContents = `<div class="container my-4">${$clone.prop('outerHTML')}</div>`;
        //     // const originalContents = document.body.innerHTML;

        //     // // Replace body with the clean printable content
        //     // document.body.innerHTML = printContents;
        //     // window.print();

        //     // // restore original page and reload to re-bind events / state
        //     // document.body.innerHTML = originalContents;
        //     // // Give browser a moment to render, then print and restore
        //     let printContents = document.querySelector('.bond-paper').innerHTML;
        //     let originalContents = document.body.innerHTML;

        //     document.body.innerHTML = `
        //       <div class="container my-4">
        //         ${printContents}
        //       </div>
        //     `;

        //     window.print();

        //     document.body.innerHTML = originalContents;
        //     setTimeout(() => {

        //         location.reload(); // keep this so your UI gets back to interactive state
        //     }, 250);
        // }

        function printOnlyBondPaper() {
    // Clone the bond-paper (work on a copy so original stays intact)
    const $clone = $('.bond-paper').first().clone();

    // Show freight as text instead of input
    const freightVal = $('#freight_input').val(); 
    $clone.find('#freight_input').remove(); 
    $clone.find('#freight_display')
        .text(parseFloat(freightVal).toFixed(2)) // format as 0.00
        .show(); 

    // Remove hidden value (not needed in print)
    $clone.find('#freight_value').remove();

    // Clean up unnecessary buttons, modals, etc. (if needed)
    $clone.find('#openModalBtn, #savePrintBtn, .modal, .modal-backdrop, .action-btn, .btn').remove();
    $clone.find('#quotation_table th:last-child').remove();
    $clone.find('#quotation_table tbody tr').each(function () {
        $(this).find('td:last-child').remove();
    });

    // Prepare print contents
    const printContents = `<div class="container my-4">${$clone.prop('outerHTML')}</div>`;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    setTimeout(() => {
        location.reload();
    }, 250);
}


        $('#savePrintBtn').off('click').on('click', saveQuotationAndPrint);

        function recalcTotals() {
            let subtotal = 0;

            $('#table_rows tr').each(function () {
                const total = parseFloat($(this).attr('data-total')) || 0;
                subtotal += total;
            });

            let freight = parseFloat($('#freight_input').val()) || 0;
            let grandTotal = subtotal + freight;

            // Update subtotal
            $('#subtotal_display').text(subtotal.toFixed(2));
            $('#subtotal_value').val(subtotal.toFixed(2));

            // Update freight
            $('#freight_display').text(freight.toFixed(2));
            $('#freight_value').val(freight.toFixed(2));

            // Update total
            $('#total_display').text(grandTotal.toFixed(2));
            $('#total_value').val(grandTotal.toFixed(2));
        }

        $(document).on('input', '#freight_input', recalcTotals);

    });


</script>