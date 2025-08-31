
<?php
main_header(['inventory']);
$session = (object) get_userdata(USER);
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
</style>

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
      <div><strong>PO No.:</strong> <span class="text-danger">001006</span></div>
      <div><strong>Date:</strong> 01/06/2025</div>
    </div>
  </div>

  <!-- left “To:” block with hanging indent, exactly like the DOC -->
  <div class="to-block mb-3">
    <div class="label">To:</div>
    <div class="value">
      <div><strong>MEED PHARMAπ</strong></div>
      <div>Generic and Branded Drug Distributor</div>
      <div>1549 TCS III BLDG. Bambang, South, Santa Cruz Manila, 1003 Metro Manila</div>
      <div>Tel. Nos.: (02) 8711-5945 / 8712-2906 / 3495-1250 / 3495-1526</div>
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
        <tr><td>5</td><td>bx/s</td><td>Astorvastatin 20MG TABLET</td><td>BRELVASTIN</td><td>10-2027</td><td>95.00</td><td>475.00</td></tr>
        <tr><td>50</td><td>bx/s</td><td>Loperamide 2mg TABLET</td><td>HARVEMIDE</td><td>09-2028</td><td>46.50</td><td>2,325.00</td></tr>
        <tr><td>20</td><td>bx/s</td><td>Loperamide 2mg TABLET</td><td>DIACURE</td><td>08-2027</td><td>36.50</td><td>730.00</td></tr>
        <tr><td>150</td><td>bx/s</td><td>Cetirizine 10mg TABLET</td><td>CETICIT</td><td>07-2027</td><td>24.00</td><td>3,600.00</td></tr>
        <tr><td>10</td><td>bx/s</td><td>Mefenamic 500mg TABLET</td><td>MEFEIN</td><td>06-2027</td><td>137.00</td><td>1,370.00</td></tr>
        <tr><td>150</td><td>bx/s</td><td>Mefenamic 500mg CAPSULE</td><td>MYREFEN</td><td>11-2027</td><td>66.25</td><td>6,625.00</td></tr>
        <tr><td>200</td><td>btl/s</td><td>Paracetamol 250mg/60ml SUSPENSION</td><td>HYFER-250</td><td>08-2027</td><td>11.00</td><td>2,200.00</td></tr>
        <tr><td>20</td><td>bx/s</td><td>Metronidazole 500mg TABLET</td><td>METROZOLE</td><td>10-2026</td><td>87.00</td><td>1,740.00</td></tr>
        <tr><td>20</td><td>bx/s</td><td>Sodium Ascorbate + Zinc CAPSULE</td><td>PROTEC ZINC</td><td>12-2026</td><td>85.00</td><td>1,700.00</td></tr>
        <tr><td>5</td><td>bx/s</td><td>Trimetazidine 35mg TABLET</td><td>WESTAR</td><td>06-2027</td><td>39.00</td><td>195.00</td></tr>
        <tr><td>5</td><td>bx/s</td><td>Vitamin B Complex TABLET</td><td>REVITAPLEX</td><td>08-2026</td><td>86.00</td><td>430.00</td></tr>
        <tr><td>10</td><td>bx/s</td><td>Vitamin B Complex TABLET</td><td>AMCOVIT-B</td><td>06-2027</td><td>62.25</td><td>622.50</td></tr>
      </tbody>
    </table>
  </div>

  <!-- Totals -->
  <div class="row justify-content-end">
    <div class="col-md-4">
      <table class="table table-borderless">
        <tr>
          <th class="text-end">SUBTOTAL</th>
          <td class="text-end">22,012.50</td>
        </tr>
        <tr>
          <th class="text-end">FREIGHT</th>
          <td class="text-end">—</td>
        </tr>
        <tr class="border-top">
          <th class="text-end">TOTAL</th>
          <td class="text-end fw-bold">22,012.50</td>
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
<script src="<?php echo base_url() ?>/assets/js/inventory/inventory.js"></script>