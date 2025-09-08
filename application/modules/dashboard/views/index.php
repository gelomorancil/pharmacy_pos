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

<div class="row ml-2">
  <div class="col-2">
      <select id="month" name="month" class="form-control form-control-sm"> ">
          <!-- Month options will be populated by JavaScript -->
      </select>
  </div>
  <div class="col-2">

      <select id="year" name="year" class="form-control form-control-sm">">
          <!-- Generate options dynamically in JavaScript for a range of years -->
      </select>
  </div>
</div>

<div class="row ml-4">
    <span><small class="text-danger">This filter updates the following cards: <b>Top 10 Selling Items, Top 10 Buyer and Item Low on Stock</b></small></span>
</div>

<section class="content">
  <div class="container-fluid mt-4">
    <div class="row d-flex align-items-stretch">
      <!-- Top 10 Selling Items -->
      <div class="col-lg-6 mb-4 d-flex">
        <div class="card w-100 h-100">
          <div class="card-header new-color"> Top 10 Selling Items </div>
          <div class="card-body p-0">
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Rank</th>
                  <th>Item Name</th>
                  <th>Sales Sold</th>
                </tr>
              </thead>
              <tbody id="top_items">
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
                  <th>Name</th>
                  <th>Total Purchases</th>
                </tr>
              </thead>
              <tbody id="top_buyers">
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
              <select class="form-control" style="width: 100%;" id="sales_year">
                    <?php $date = date('Y'); ?>
                    <option selected="selected" value="<?= $date ?>"><?= $date ?></option>
                    <option value="<?= $date - 1 ?>"><?= $date - 1 ?></option>
                    <option value="<?= $date - 2 ?>"><?= $date - 2 ?></option>
                    <option value="<?= $date - 3 ?>"><?= $date - 3 ?></option>
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
              <tbody id="report-summary">
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