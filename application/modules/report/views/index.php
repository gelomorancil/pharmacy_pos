<?php
main_header(['sales_report']);
$session = (object) get_userdata(USER);

?>
<!-- ############ PAGE START-->
<style>
      /* Change hover color to light gray */
    .select2-results__option--highlighted {
        background-color: #f2f2f2 !important; /* light gray background */
        color: #000 !important; /* black text */
    }

    /* Optional: make the cursor consistent */
    .select2-results__option {
        cursor: pointer;
    }

    .select2-results__options {
        max-height: 400px !important;  /* default is ~200px */
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0">Dashboard</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sales Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <div class="col-3">
                                    <label for="">Select Type of Report:</label>
                                    <select id="report_type" class="form-control">
                                        <option selected value="sales">Sales</option>
                                        <option value="inventory">Inventory</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm mb-2">
                                                <label for="">Select Date Range:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control date_range" id="sales_date_range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6" id="sales_data_types">
                                        <label for="">Select Data to Load:</label>
                                        <select id="data_type_to_load" class="form-control">
                                            <option selected value="">All</option>
                                            <option value="0">Active</option>
                                            <option value="1">Voided</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">
                                    <b>
                                        <h4>
                                            <cont id="type_of_report">Sales </cont>Report:
                                        </h4>
                                    </b>
                                    <p class="m-b-0 _300" style="font-size: 85%;"><i class="fa fa-info"></i> NOTE:
                                        Reports autoloads the monthly (current month), reports only to reduce loading
                                        times. Use
                                        the date range selector to load reports in-between specific dates.</p>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="ml-2 mr-2" id="load_report">
                        <!-- Report Content Loaded Here Via JS -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</section>

<!-- Modals -->
<div class="modal fade" id="view-individual-item">

    <!-- Hidden Flag Variables -->
    <input disabled hidden id="parent_id" value="">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Sales Details Per-item:</cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="load_individual_items"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-md btn-primary" id="reprint_receipt"><b>Re-print
                            Receipt</b></button>
                    <!-- <button type="button" class="btn btn-md btn-danger" id="void_sale" style="display: <?=$session->Role_ID == 1 ? '' : 'none' ?>"><b>Void</b></button> -->
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="void-item">

    <!-- Hidden Flag Variables -->
    <input disabled hidden id="void_item_id" value="">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Void Item</cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Reason for voiding item <b id="void_item_name"></b>:
                <div class="form-group">
                    <textarea class="form-control" id="void_reason" rows="4" placeholder="Enter reason here..."></textarea>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="">Replace with Item:</label>
                    </div>
                    <div class="col-sm-8">
                        <label for="">Select Item:</label>
                         <select id="item_4" class="select2 form-control" style="width: 100%;">
                            <option value="" disabled selected>-- Select Category --</option>
                            <?php foreach($items_profiles as $key => $value){ ?>
                                <option 
                                    value="<?= $value->item_id ?>"
                                    data-id="<?=$value->item_id?>" 
                                    data-item_name="<?=$value->item_name?>" 
                                    data-item_code="<?=$value->item_code?>" 
                                    data-short_name="<?=$value->short_name?>" 
                                    data-description="<?=$value->description?>" 
                                    data-category="<?=$value->category?>" 
                                    data-status="<?=$value->active?>" 
                                    data-strenght="<?=$value->strenght?>"
                                    data-packaging="<?=$value->packaging?>"
                                    data-uom="<?=$value->uom?>"
                                    data-classification="<?=$value->classification?>"
                                    data-storage_condition="<?=$value->storage_condition?>"
                                    data-distributor="<?=$value->distributor?>">
                                    <?= $value->item_name ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-md btn-success" id="void_replace_item"><b>Void and Save replaced item</b></button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <div class="modal fade" id="edit-individual-item" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Details:</cont>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: 63vh;">
                <div class="row">
                    <div class="col-12">
                        <div id="load_individual_items"></div>
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
</div> -->

<div class="modal fade" id="verify-void" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" style="max-width: 380px;">
        <div class="modal-content" style="border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.15);">
            
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h5 class="modal-title" style="margin: 0; font-weight: bold;">User Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="font-size: 1.2rem; padding: 0 10px; border: none; background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <input type="text" class="form-control" id="void_username" placeholder="Enter Username"
                        style="border-radius: 4px; height: 40px;">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="password" class="form-control" id="void_password" placeholder="Enter Password"
                        style="border-radius: 4px; height: 40px;">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="justify-content: space-between; padding: 10px 20px;">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                    style="padding: 5px 15px;">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="verify_void"
                    style="padding: 5px 20px;">Verify</button>
            </div>
        </div>
    </div>
</div>


<!-- Hidden Receipt Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body" style="overflow-y: auto; height: 63vh;">
                <div id="to_be_printed">
                    <!-- Receipt To be Printed Loaded Here Via JS -->
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/report/report.js"></script>
<script>
     $('#item_4').select2({
        width: '100%',
        dropdownParent: $('body'),
        matcher: function(params, data) {
            if ($.trim(params.term) === '') return data;

            const term = params.term.toLowerCase();
            const text = (data.text || '').toLowerCase();
            let found = text.indexOf(term) > -1;

            if (!found && data.element) {
                const $option = $(data.element);
                $.each($option.data(), function(key, value) {
                    if (String(value).toLowerCase().indexOf(term) > -1) {
                        found = true;
                        return false;
                    }
                });
            }
            return found ? data : null;
        },
        templateResult: function(option) {
            if (!option.id) return option.text;

            const data = $(option.element).data();
            const statusColor = data.status == 1 ? 'green' : 'red';

            let html = `
                <div class="p-1">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <div class="d-flex align-items-center">
                                <span style="
                                    display:inline-block;
                                    width:10px;
                                    height:10px;
                                    border-radius:50%;
                                    background:${statusColor};
                                    margin-right:6px;
                                "></span>
                                <strong>${data.item_name || option.text}</strong>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <span class="text-danger">GENERIC NAME:</span> ${data.short_name || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">MANUFACTURER:</span> ${data.item_code || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">DISTRIBUTOR:</span> ${data.distributor || '-'}
                            </small>
                        </div>
                    </div>

                    <div class="border-top pt-1">
                        <small class="text-muted d-block">
                            <span class="text-primary">CATEGORY:</span> ${data.category || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STRENGTH:</span> ${data.strenght || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STORAGE:</span> ${data.storage_condition || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">UOM:</span> ${data.uom || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">PACKAGING:</span> ${data.packaging || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">DESCRIPTION:</span> ${data.description || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">CLASSIFICATION:</span> ${data.classification || '-'}
                        </small>
                    </div>
                </div>
            `;

            return $(html);  // <-- required fix
        },

        // templateSelection: function(option) {
        //     if (!option.id) return option.text;
        //     const data = $(option.element).data();
        //     return data.item_name || option.text;
        // },
        templateSelection: function(option) {
            if (!option.id) return option.text;
            const data = $(option.element).data();
            return data.item_name || option.text;
        },
        escapeMarkup: function(m) { return m; } // Allow HTML rendering
    });

    // $('#item_2').select2('destroy');
    // $('#item_2').select2();
    $(document).on('select2:open', () => {
        setTimeout(() => {
            const field = document.querySelector('.select2-container--open .select2-search__field');
            field.focus();
            field.select();
        }, 10);
    });
</script>