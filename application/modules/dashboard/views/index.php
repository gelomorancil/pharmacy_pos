<?php
main_header(['dashboard']);
?>
  <style>

    /* Scrollable table for low stock */
    .scrollable-table {
      max-height: 300px;
      overflow-y: auto;
    }
    /* Fix table header when scrolling */
    .scrollable-table thead th {
      position: sticky;
      top: 0;
      background: #e9ecef;
      z-index: 2;
    }
  </style>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
<div class="container-fluid mt-4">
  <div class="row d-flex align-items-stretch">
    <!-- Top 10 Selling Items -->
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card w-100 h-100">
        <div class="card-header new-color">Top 10 Selling Items</div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Item Name</th>
                <th>Sales Sold</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Item A</td><td>120</td></tr>
              <tr><td>Item B</td><td>95</td></tr>
              <tr><td>Item C</td><td>80</td></tr>
              <tr><td>Item D</td><td>70</td></tr>
              <tr><td>Item E</td><td>65</td></tr>
              <tr><td>Item F</td><td>50</td></tr>
              <tr><td>Item G</td><td>40</td></tr>
              <tr><td>Item H</td><td>35</td></tr>
              <tr><td>Item I</td><td>25</td></tr>
              <tr><td>Item J</td><td>20</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Top 10 Buyers -->
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card w-100 h-100">
        <div class="card-header new-color">Top 10 Buyers</div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Buyer Name</th>
                <th>Email</th>
                <th>Total Purchases</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>John Doe</td><td>john@example.com</td><td>₱50,000</td></tr>
              <tr><td>Jane Smith</td><td>jane@example.com</td><td>₱45,000</td></tr>
              <tr><td>Michael Reyes</td><td>mike@example.com</td><td>₱40,000</td></tr>
              <tr><td>Ana Cruz</td><td>ana@example.com</td><td>₱38,500</td></tr>
              <tr><td>Robert Lee</td><td>robert@example.com</td><td>₱36,000</td></tr>
              <tr><td>Maria Santos</td><td>maria@example.com</td><td>₱34,000</td></tr>
              <tr><td>Carlos Tan</td><td>carlos@example.com</td><td>₱32,000</td></tr>
              <tr><td>Lisa Wang</td><td>lisa@example.com</td><td>₱30,000</td></tr>
              <tr><td>Paul Gomez</td><td>paul@example.com</td><td>₱28,000</td></tr>
              <tr><td>Sophia Lim</td><td>sophia@example.com</td><td>₱25,000</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row d-flex align-items-stretch">
    <!-- Low Stock Items -->
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card w-100 h-100">
        <div class="card-header new-color">Items Low on Stock</div>
        <div class="card-body p-0">
          <div class="scrollable-table">
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Item</th>
                  <th>Remaining Stock</th>
                </tr>
              </thead>
              <tbody>
                <tr class="table-danger"><td>Item X</td><td>2</td></tr>
                <tr class="table-danger"><td>Item Y</td><td>4</td></tr>
                <tr><td>Item Z</td><td>10</td></tr>
                <tr><td>Item W</td><td>8</td></tr>
                <tr><td>Item Q</td><td>15</td></tr>
                <tr><td>Item L</td><td>12</td></tr>
                <tr><td>Item M</td><td>9</td></tr>
                <tr><td>Item N</td><td>7</td></tr>
                <tr><td>Item O</td><td>3</td></tr>
                <tr><td>Item P</td><td>6</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Monthly Sales -->
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card w-100 h-100">
        <div class="card-header new-color d-flex justify-content-between align-items-center">
          <span>Running Monthly Sales</span>
          <form>
            <select name="year" class="form-control form-control-sm">
              <option value="2025" selected>2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
            </select>
          </form>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Month</th>
                <th>Sales</th>
                <th>Expense</th>
                <th>Gross</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>January</td><td>₱100,000</td><td>₱40,000</td><td>₱60,000</td></tr>
              <tr><td>February</td><td>₱90,000</td><td>₱35,000</td><td>₱55,000</td></tr>
              <tr><td>March</td><td>₱110,000</td><td>₱45,000</td><td>₱65,000</td></tr>
              <tr><td>April</td><td>₱120,000</td><td>₱50,000</td><td>₱70,000</td></tr>
              <tr><td>May</td><td>₱105,000</td><td>₱42,000</td><td>₱63,000</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/dashboard/dashboard.js"></script>