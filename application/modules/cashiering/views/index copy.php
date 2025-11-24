<?php
main_header(['cashiering']);
$session = (object) get_userdata(USER);

// var_dump($items);
?>
<!-- ############ PAGE START-->
<input hidden id="created_by" value="<?= $session->ID ?>">
<input hidden id="item_profile_id" value="">

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cashier</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cashier</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">

    <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card card-gray-dark" style="height: 50rem;">
                <div class="card-header">
                    <h3 class="card-title">CASHIER :
                        <?= strtoupper($session->LName) . ", " . strtoupper($session->FName) ?>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-1">
                            <button class="btn btn-dark form-control" disabled style="font-size: 0.7vw;">CODE:</button>
                        </div>
                        <div class="col-9">
                            <input type="text" id="item_code" class="form-control text-center"
                                style="font-size: 20px; font-weight: bold;" placeholder="Enter Item Code" autofocus>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-secondary form-control" id="submit_item_code"
                                style="font-size: 0.6vw;"><b>ENTER</b></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-primary form-control" id="search_item"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div id="load_items">
                                <!-- Scanned Items Table Loaded Here Via JS -->
                                <div style="max-height: 40rem; overflow-y: auto; overflow-x: hidden;">
                                    <table id="example2" class="table table-bordered table-striped table-hover"
                                        style="border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width:15%;">Item Code</th>
                                                <th style="width:15%;">Item Name</th>
                                                <th style="width:30%;">Description</th>
                                                <th style="width:10%;">Price</th>
                                                <th style="width:10%;">Quantity</th>
                                                <th style="width:10%;">Discount</th>
                                                <th style="width:10%;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="scanned_items">
                                            <!-- <tr>
                                            <td colspan="7" class="text-center">No Available Data</td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <b style="font-size: 3rem; font-weight: bold;">
                                <cont style="font-size: 3rem">Php</cont>
                                <totalAmount id="main_total_amount_due">0.00</totalAmount>
                            </b>

                            <p>Total Amount Due</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money-bill"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
            </div>

            <div class="card card-gray-dark" style="height: 40.25rem;">
                <div class="card-header">
                    <h3 class="card-title">Sales Information:</h3>
                </div>
                <div class="card-body">
                    <div class="card p-3" style="background-color:#696D79">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mx-1">
                                    <div class="col-12 d-flex justify-content-center">
                                        <cont id="last_item_name" style="font-size:110%; font-weight:bold; color:white">
                                            -
                                            - - - - - - - - -
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Price:</cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="last_item_price"
                                            style="font-size:100%; font-weight:bold; color:white">----</cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Quantity:</cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="last_item_quantity"
                                            style="font-size:100%; font-weight:bold; color:white">----
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Discount:</cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="last_item_discount"
                                            style="font-size:100%; font-weight:bold; color:white">----
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Total:</cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="last_item_total"
                                            style="font-size:100%; font-weight:bold; color:white">----</cont>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-3 pb-5" style="background-color:#696D79">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mx-1">
                                    <div class="col-12 d-flex justify-content-center">
                                        <cont style="font-size:110%; font-weight:bold; color:white">
                                            SALES SUB TOTALS
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Sub Total:</cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="amount_due" style="font-size:100%; font-weight:bold; color:white">----
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Total Quantity:
                                        </cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="total_quantity" style="font-size:100%; font-weight:bold; color:white">
                                            ----
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Total Discounts:
                                        </cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="total_discounts"
                                            style="font-size:100%; font-weight:bold; color:white">----
                                        </cont>
                                    </div>
                                </div>
                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Total Amount Due:
                                        </cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="total_amount_due"
                                            style="font-size:100%; font-weight:bold; color:white">----</cont>
                                    </div>
                                </div>

                                <br>
                                <br>
                                <br>

                                <div class="row mx-1">
                                    <div class="col-6 d-flex justify-content-start">
                                        <cont style="font-size:100%; font-weight:bold; color:white">Last S.O. Number:
                                        </cont>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <cont id="last_SO_number" style="font-size:100%; font-weight:bold; color:white">
                                            ----</cont>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-6">
                            <button class="btn btn-primary form-control" id="retrieve_SO"><b>RETRIEVE S.O.
                                    DATA</b></button>
                        </div> -->
                        <div class="col-12">
                            <button class="btn btn-success form-control" id="tend_customer"><b>PROCESS
                                    PAYMENT</b></button>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Modals -->

<!-- Enter Item Modal -->
<div class="modal fade" id="modal-enter-item" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Item: <cont id="display_item_name" style="color: red"></cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" hidden disabled id="item_profile_id">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Item Name:</label>
                            <input type="text" id="item_name" class="form-control inpt" placeholder="Item Name"
                                disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Code:</label>
                            <input type="text" id="code" class="form-control inpt" placeholder="Item Code" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Unit Price:</label>
                            <input type="text" id="price" class="form-control inpt" placeholder="Item Price" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Short Name:</label>
                            <input type="text" id="short_name" class="form-control inpt" placeholder="Item Short Name"
                                disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Quantity:</label>
                            <input type="number" id="quantity" class="form-control inpt" placeholder="Enter Quantity">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="">Discount:</label>
                            <input type="number" id="discount" class="form-control inpt" placeholder="Enter Percentage"
                                value="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="">Description:</label>
                        <textarea id="item_description" class="form-control" rows="3" disabled
                            placeholder="Item Description"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="add_item">Add Item</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Search Item Modal -->
<div class="modal fade" id="modal-search-item" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Search Item: <cont id="display_item_name" style="color: red"></cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="load_item_table">
                            <!-- Table Loaded Here Via JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <!-- <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="add_item">Add Item</button> -->
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Update Item Modal -->
<div class="modal fade" id="modal-update-item" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Item: <cont id="display_item_name_update" style="color: red"></cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="">Quantity:</label>
                            <input type="number" id="update_quantity" class="form-control inpt" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="">Discount:</label>
                            <input type="number" id="update_discount" class="form-control inpt" placeholder="Discount">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="update_item">Update Item</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Tend Customer Modal -->
<div class="modal fade" id="modal-tender-customer" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <b style="font-size: 3rem; font-weight: bold;">
                                    <cont style="font-size: 3rem">Php</cont>
                                    <totalAmount id="tender_total_amount">0.00</totalAmount>
                                </b>

                                <p>Total Amount Due</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money-bill"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>
                </div>
                <div class="card card-gray-dark" style="height: 63vh;">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Process Sales:</h3>
                    </div> -->
                    <div class="card-body" style="overflow-y: auto;">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">PAYMENT TYPE:</label>
                                    <select class="form-control" style="width: 100%;" id="payment_type">
                                        <option value="CASH">CASH</option>
                                        <option value="ONLINE">ONLINE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">DISCOUNT TYPE:</label>
                                    <select class="form-control" style="width: 100%;" id="discount_type">
                                        <option value="NO DISCOUNT">NO DISCOUNT</option>
                                        <option value="SENIOR">SENIOR</option>
                                        <option value="PWD">PWD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">AMOUNT RECIEVED:</label>
                                    <input type="number" class="form-control text-center" id="amount_recieved"
                                        style="height:8vh; font-size:180%; font-weight:bold;" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">CHANGE:</label>
                                    <input type="number" class="form-control text-center" id="change"
                                        style="height:8vh; font-size:180%; font-weight:bold;" disabled value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">SELECT BILLS:</label>
                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_20"><b>20</b></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_50"><b>50</b></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_100"><b>100</b></button>
                                        </div>
                                    </div>
                                    <div class="row mx-2 mt-2">
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_200"><b>200</b></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_500"><b>500</b></button>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-md btn-primary form-control"
                                                id="bill_1000"><b>1000</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-md btn-danger flex-fill mr-2" data-dismiss="modal"
                                    id="cancel_payment"><b>Cancel</b></button>
                                <button class="btn btn-md btn-primary flex-fill mr-2" id="add_remarks"
                                    data-toggle="modal" data-target="#modal-remarks" data-dismiss="modal"><b>Add
                                        Remarks</b></button>
                                <button class="btn btn-md btn-success flex-fill" data-dismiss="modal"
                                    id="save_print"><b>Save & Print Receipt</b></button>

                                <button class="btn btn-md btn-success flex-fill" hidden
                                    id="new_transaction"><b>New Transaction</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Online Payment Details Modal -->
<div class="modal fade" id="modal-online-payment-details" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div class="card card-gray-dark" style="height: 30vh;">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Process Sales:</h3>
                    </div> -->
                    <div class="card-body" style="overflow-y: auto;">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">REFERENCE NUMBER:</label>
                                    <input type="text" class="form-control text-center" id="reference_number"
                                        placeholder="Enter Reference Number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">SELECT FILE:</label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="proof_image" accept="image/*">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <button class="btn btn-md btn-danger form-control" data-toggle="modal"
                                    data-target="#modal-tender-customer" data-dismiss="modal"><b>Back</b></button>
                            </div>
                            <div class="col-8">
                                <button class="btn btn-md btn-success form-control" data-dismiss="modal"
                                    id="online_proceed"><b>Proceed</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Remarks Modal -->
<div class="modal fade" id="modal-remarks" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div class="card card-gray-dark" style="height: 25vh;">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Process Sales:</h3>
                    </div> -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group w-100">
                                    <label for="">Remarks:</label>
                                    <textarea id="remarks" class="form-control" rows="3"
                                        placeholder="Enter Remarks"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                &nbsp;
                                <!-- <button class="btn btn-md btn-danger form-control" data-toggle="modal" data-target="#modal-tender-customer"
                                    data-dismiss="modal"><b>Back</b></button> -->
                            </div>
                            <div class="col-8">
                                <button class="btn btn-md btn-success form-control" data-toggle="modal"
                                    data-target="#modal-tender-customer" data-dismiss="modal"><b>Save and
                                        Proceed</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div id="to_be_printed"></div>
</div>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script>
    // $("#example2").DataTable({
    //     "responsive": false,
    //     "lengthChange": false,
    //     "autoWidth": false,
    //     "searching": false,
    //     // "buttons": ["copy", "csv", "excel", "pdf", "print"],
    //     "pageLength": 10,
    // }).buttons().container();
</script>
<script src="<?php echo base_url() ?>/assets/js/cashiering/cashiering.js"></script>