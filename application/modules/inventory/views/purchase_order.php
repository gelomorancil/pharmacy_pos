
<?php
main_header(['inventory']);
$session = (object) get_userdata(USER);
// var_dump($po);
// var_dump($po_items);
$subtotal = floatval(0);
?>
<style>
    .body-po {
        font-size: 14px;
        background-color: white;
        padding: 20px;
    }
    .signature {
      height: 80px;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px dashed #999;
      border-radius: 6px;
    }
    .logo-placeholder {
      width: 100px;
      height: 100px;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px dashed #999;
      margin-right: 15px;
    }

    .po-section { border-top: 1px solid #e5e5e5; padding-top: .75rem; margin-top: .5rem; }
  .po-header { position: relative; }
  .po-header h5 { font-weight: 700; letter-spacing: .5px; }
  .po-meta { position: absolute; right: 0; top: 0; text-align: right; line-height: 1.2; }
  /* “To:” hanging indent like the DOC */
  .to-block { display: -ms-flexbox; display: flex; }
  .to-block .label { width: 40px; min-width: 40px; font-weight: 600; }
  .to-block .value { padding-left: .5rem; }

  @media print {
  body * {
    visibility: hidden;
  }
  .body-po, .body-po * {
    visibility: visible;
  }
  .body-po {
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

<div class="text-center mt-4 mb-3">
  <button class="btn btn-primary" onclick="printPO()">🖨 Print PO</button>
</div>

<div class="container my-4 body-po">


  <!-- Header -->
  <div class="row align-items-center mb-3">
    <div class="col-md-1 text-center">
      <div class="logo-placeholder">Logo</div>
    </div>
    <div class="col-md-11 text-center">
      <h5 class="mb-0 font-weight-bold">ZANNA HEALTH AND WELLNESS PRODUCTS TRADING</h5>
      <p class="mb-0">Door #3 Integrated Sugarcane Growers of Negros Inc. Bldg., Mansilingan Bacolod City</p>
    </div>
  </div>

  <!-- Purchase Order Info -->
  <div class="po-section">
  <!-- centered title + right meta (absolute) -->
  <div class="po-header mb-2">
    <h5 class="text-center mb-1">PURCHASE ORDER</h5>
    <div class="po-meta">
      <div><strong>PO No.:</strong> <span class="text-danger">PO-<?=$po->po_num?></span></div>
      <div><strong>Date:</strong> <?=date("m/d/Y", strtotime($po->date_added))?></div>
    </div>
  </div>

  <!-- left “To:” block with hanging indent, exactly like the DOC -->
  <div class="to-block mb-3">
    <div class="label">To:</div>
    <div class="value">
      <!-- <div><strong>MEED PHARMAπ</strong></div>
      <div>Generic and Branded Drug Distributor</div>
      <div>1549 TCS III BLDG. Bambang, South, Santa Cruz Manila, 1003 Metro Manila</div>
      <div>Tel. Nos.: (02) 8711-5945 / 8712-2906 / 3495-1250 / 3495-1526</div> -->
       <div><strong><?=$supplier_deets->supplier_name?></strong></div>
      <div><?=$supplier_deets->contact_person?></div>
      <div><?=$supplier_deets->address?></div>
      <div>Contact Details.: <?=$supplier_deets->contact_number_1?> / <?=$supplier_deets->contact_number_2?> / <?=$supplier_deets->email?> </div>
    </div>
  </div>

  <p class="font-weight-bold mb-2" style="width: 90%; margin: 0 auto; text-align: center;">Please deliver the following items</p>

</div>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>Quantity</th>
          <th>Unit</th>
          <th>Item Description</th>
          <th>Brand</th>
          <th>Expiry</th>
          <th>Unit Price</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($po_items as $items) {

          $row_amount = floatval($items->qty * $items->unit_price);
          $subtotal += $row_amount;
          ?>
        <tr>
          <td><?=$items->qty?></td>
          <td><?=$items->unit_of_measure?></td>
          <td class="text-start"><?=$items->description?></td>
          <td><?=$items->item_name?></td>
          <td><?=($items->date_expiry != '0000-00-00') ? date("m/Y", strtotime($items->date_expiry)) : ''?></td>
          <td class="text-end"><?=number_format($items->unit_price, 2)?></td>
          <td class="text-end"><?=number_format($row_amount, 2)?></td>
        <?php }
        $freight = 0;
        $total = $subtotal + $freight;
        ?>
      </tbody>
    </table>
  </div>

  <!-- Totals -->
  <div class="row justify-content-end">
    <div class="col-md-4">
      <table class="table table-borderless">
      <tr>
          <th class="text-end">SUBTOTAL</th>
          <td class="text-end"><?= number_format($subtotal, 2) ?></td>
        </tr>
        <tr>
          <th class="text-end">FREIGHT</th>
          <td class="text-end"><?= ($freight > 0) ? number_format($freight, 2) : '—' ?></td>
        </tr>
        <tr class="border-top">
          <th class="text-end">TOTAL</th>
          <td class="text-end fw-bold"><?= number_format($total, 2) ?></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Signatures -->
  <div class="row mt-5">
    <div class="col-md-6 text-center">
      <div class="signature">Signature</div>
      <p class="mb-0 fw-bold">GEREYLIE FAITH S. RESURRECCION</p>
      <p>Account Manager</p>
    </div>
    <div class="col-md-6 text-center">
      <div class="signature">Signature</div>
      <p class="mb-0 fw-bold">ARGIEL P. RESURRECCION</p>
      <p>Owner</p>
    </div>
  </div>

  <!-- Footer -->
  <div class="text-center mt-4">
    <p class="mb-0"><em>"Bringing Health Closer to You"</em></p>
    <p class="mb-0">Email: zannahealthandwellness@gmail.com | Contact No: 09988570191; 09292661935</p>
  </div>

</div>

<?php
main_footer();
?>

<script>
function printPO() {
  let printContents = document.querySelector('.body-po').innerHTML;
  let originalContents = document.body.innerHTML;

  document.body.innerHTML = `
    <div class="container my-4">
      ${printContents}
    </div>
  `;

  window.print();

  document.body.innerHTML = originalContents;
  location.reload(); // reload to restore events
}
</script>


<script src="<?php echo base_url() ?>/assets/js/inventory/inventory.js"></script>