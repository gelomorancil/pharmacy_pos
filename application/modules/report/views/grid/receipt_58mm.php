<style>
    @media print {
        @page {
            size: auto;
            margin: 0;
        }

        .full-width-print {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            transform: scale(3.7);
            transform-origin: top left;
        }

        .full-width-print h2,
        .full-width-print p {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .full-width-print #total-amount {
            font-size: 18px;
        }

        .full-width-print table {
            width: 100%;
            font-size: 80%;
            border-collapse: collapse;
        }

        .full-width-print table th,
        .full-width-print table td {
            padding: 5px;
        }

        .full-width-print .row-separator {
            border-top: 1px solid #000;
            margin: 5px 0;
        }
    }
</style>

<!-- HTML Structure -->
<div class="full-width-print"
    style="margin-left: 0rem; margin-top: 1rem; padding: 0; font-family: Verdana, Geneva, sans-serif; width: 65mm;">
    <div>
        <div style="text-align: center; font-size: 13px; margin-bottom: 10px;">
            <br>
            <cont>Date: <?= date('F d, Y H:i:s', strtotime($date_created)) ?></cont>
            <br>
            <cont>Control #: <?= $control_number ?></cont>
            <br>
            <cont><small>Sold to: <?= $buyer_name ?></small></cont>
            <br>

        </div>
        <div id="items-container" style="margin-bottom: 10px;">
            <!-- Table structure with no borders -->
            <table style="width: 100%; border-collapse: collapse; font-size:80%;">
                <thead>
                    <tr>
                        <th style="text-align: left; font-weight: 500;">ITEM/s:</th>
                        <th style="text-align: center; font-weight: 500;">QTY:</th>
                        <th style="text-align: right; font-weight: 500;">PRICE:</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample items, to be populated dynamically -->
                    <?php foreach ($items as $item) { ?>
                        <tr style="margin-top: 5px;">
                            <td style="text-align: left; padding: 5px;">
                                <?= $item['item_name']." ".$item['strenght']?>
                            </td>
                            <td style="text-align: center; padding: 5px;">
                                <?php
                                    $qty = (int) $item["quantity"];
                                    $pcs_box = (int) $item["pcs_box"];
                                    $pcs_stub = (int) $item["pcs_stub"];
                                    $display = array();

                                    if ($pcs_box > 0 && $qty >= $pcs_box) {
                                        $boxes = floor($qty / $pcs_box);
                                        $display[] = $boxes . " box(es)";
                                        $qty = $qty % $pcs_box;
                                    }
                                    
                                    if ($pcs_stub > 0 && $qty >= $pcs_stub) {
                                        $stubs = floor($qty / $pcs_stub);
                                        $display[] = $stubs . " stub(s)";
                                        $qty = $qty % $pcs_stub;
                                    }
                                    
                                    if ($qty > 0) {
                                        $display[] = $qty . " pc(s)";
                                    }
                                    
                                    echo !empty($display) ? implode(", ", $display) : "0 pc(s)";
                                    ?>
                            </td>
                            <td style="text-align: right; padding: 5px;">
                                <!-- Php <?= number_format($item['quantity'] * $item['unit_price'], 2) ?> -->
                                Php <?= number_format($item['total_price'], 2) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-top: -10px; margin-bottom: -10px;">
            ---------------------------------------
        </div>
        <div id="items-container" style="font-size:90%;">
            <div class="row" style="display: flex; margin-left: -5px; margin-right: -5px; margin-top: 5px">
                <div class="col-6" style="flex: 1; text-align: left;">
                    <span style="font-size: 100%;">Sub Total:</span>
                </div>
                <div class="col-6" style="flex: 1; text-align: right;">
                    Php <span style="font-size: 100%;"><?= number_format($sub_total, 2) ?></span>
                </div>
            </div>
            <div class="row" style="display: flex; margin-left: -5px; margin-right: -5px; margin-top: 5px">
                <div class="col-6" style="flex: 1; text-align: left;">
                    <span style="font-size: 100%;">Discount:</span>
                </div>
                <div class="col-6" style="flex: 1; text-align: right;">
                    Php <span style="font-size: 100%;"><?= number_format($discount_amount, 2) ?></span>
                </div>
            </div>
            <div class="row" style="display: flex; margin-left: -5px; margin-right: -5px; margin-top: 5px">
                <div class="col-6" style="flex: 1; text-align: left;">
                    <span style="font-size: 100%;">Discount Type:</span>
                </div>
                <div class="col-6" style="flex: 1; text-align: right;">
                    <span style="font-size: 100%;"><?= $discount_type ?></span>
                </div>
            </div>

        </div>

        <div style="font-weight: bold; font-size: 15px; margin-top: 10px; text-align: right;" id="total-amount">
            <div class="row" style="display: flex; margin-left: -5px; margin-right: -5px; margin-top: 5px">
                <div class="col-6" style="flex: 1; text-align: left;">
                    <span style="font-size: 100%;">Total:</span>
                </div>
                <div class="col-6" style="flex: 1; text-align: right;">
                    Php <span style="font-size: 100%;" id="receipt_total_amount"><?= number_format($total_amount, 2) ?></span>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 10px; font-size: 13px;">
            <c>Thank you for your purchase!</c>
            <br>


        </div>
        <div style="text-align: center; margin-top: 10px; font-size: 10px;">
            <c>This is not an official receipt but</c>
            <br>
            <c>serves as your proof of purchase</c>
            <br>
        </div>

    </div>
</div>