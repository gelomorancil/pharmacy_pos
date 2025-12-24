<style>
     .report-title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .section-title {
            font-weight: bold;
            margin-top: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .amount {
            text-align: right;
            font-weight: 500;
        }

        .total-line {
            border-top: 2px solid #000;
            margin-top: 10px;
            padding-top: 8px;
            font-weight: bold;
        }

        .profit {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }
</style>
<!-- HEADER -->
    <div class="row mb-3 mt-5">
        <div class="col-md-8">
            <div class="report-title">
               
            </div>
            <!-- INSERT THE SELECTED CATEGORY HERE-->
            <div>Category: Meds, J&T, Refreshment</div> 
        </div>
        <div class="col-md-4 text-right">
            <strong>Sales:</strong>
            <h5><?= number_format($total_sales, 2) ?></h5>
        </div>
    </div>

    <!-- PURCHASES -->
    <div class="section-title">Purchases (Delivery Report)</div>

    <?php
        $total_purchases = 0;
        foreach($get_purchases as $purchase){ 
            $total_purchases += $purchase->total_purchase_amount;
            ?>
            <div class="row mt-2">
                <div class="col-8"><?php echo $purchase->Category; ?></div>
                <div class="col-4 amount">₱<?php echo number_format($purchase->total_purchase_amount, 2); ?></div>
            </div>
        <?php } ?>
  
    <div class="row total-line text-danger">
        <div class="col-8">Total Purchases</div>
        <div class="col-4 amount">₱<?=number_format($total_purchases, 2)?></div>
    </div>

    <!-- EXPENSES -->
    <div class="section-title">Expenses</div>
    <?php
        $total_expenses = 0;
        foreach($expenses as $expense){ 
            $total_expenses += $expense->Actual_Money; 
            ?>
            
        <div class="row mt-2">
            <div class="col-8"><?php echo $expense->Descr; ?></div>
            <div class="col-4 amount">₱<?php echo number_format($expense->Actual_Money, 2); ?></div>
        </div>
       <?php } ?>
    

    <div class="row total-line text-danger">
        <div class="col-8">Total Expenses</div>
        <div class="col-4 amount">₱<?php echo number_format($total_expenses, 2); ?></div>
    </div>

    <!-- PROFIT / LOSS -->
    <div class="section-title">Total (Profit / Loss)</div>

    <div class="row mt-3">
        <div class="col-6"></div>
        <div class="col-6 profit">
            ₱<?= number_format($total_sales - $total_expenses, 2) ?>
        </div>
    </div>
