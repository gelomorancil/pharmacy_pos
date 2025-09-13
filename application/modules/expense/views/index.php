<?php
main_header(['expense']);
$session = (object)get_userdata(USER);
?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Expenses</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Expenses</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <!-- SEARCHED CUSTOMER DEAILS -->
        <div class="col-md-4 cust_details" id="">
            <div class="card">
                <div class="card-header new-color">
                    <h3 class="card-title">Add Expense</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" id="date_exp" class="form-control inpt_edit" value="<?=date('Y-m-d')?>" placeholder="Date">
                            <input type="text" id="ID"value="" hidden>
                        </div>

                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" id="desc" class="form-control inpt_edit" placeholder="Description">
                        </div>


                        <div class="form-group">
                            <label for="">Actual Money</label>
                            <input type="number" id="aamount" class="form-control inpt_edit" placeholder="Actual Money">
                        </div>

                        <!-- <div class="form-group">
                            <label for="">Insert to Branch</label>
                            <select class="form-control" style="width: 100%;" id="Branch">
                                <option value=""></option>
                                <?php
                                    foreach($branch as $key => $value){ ?>
                                        <option value="<?=$value->List_name?>"><?=$value->List_name?></option>
                                    <?php }
                                ?>
                            </select>
                        </div> -->


                        <div class="form-group act_exp" style="display: <?=$session->Role == "Admin" ? "" : "none"?>">
                            <label for="">Actual Expenses</label>
                            <input type="number" id="aexp" class="form-control inpt_edit" placeholder="Actual Expenses">
                        </div>

                        <div class="form-group act_balance" style="display: <?=$session->Role == "Admin" ? "" : "none"?>">
                            <label for="">Balance</label>
                            <input type="number" id="balance" class="form-control inpt_edit" placeholder="--.--" disabled>
                        </div>

                        <div class="form-group act_image" style="display: <?=$session->Role == "Admin" ? "" : "none"?>">
                            <label for="">Upload Image</label>
                            <input type="file" name="image_input_name" id="image" class="form-control">
                            <input type="text" name="image_input_name" id="image_2" class="form-control" style="display:none">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="expbtn">Add</button>
                        <button type="button" class="btn btn-warning" id="expedit" style="display: none">Update</button>
                        <button type="button" class="btn btn-primary" id="add_image" style="display: none">Add Image</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- CUSTOMERS ORDER HISTORY -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header new-color">
                    <div class="card-title">Expenses for today</div>
                </div>
                    <!-- Modified by KYLE 12-19-2023 -->
                    <!-- <div class="input-group input-group-sm" style="margin-top:1rem; margin-left:1rem; margin-left:1rem;">

                        <select class="form-control-sm mr-1" style="width: 30%;" id="branch_filter" <?=empty($session->Branch) ? '' : 'hidden'?>>
                            <option value="All">All Branch</option>
                            <?php 
                                foreach($branch as $key => $x){ ?>
                                <option value="<?=$x->List_name?>"><?=$x->List_name?></option>
                            <?php } ?>
                        </select>
                        <label class="mr-2"for="" style=" margin-left:1rem;">From</label>
                        <input type="date" id="d_from" class="form-control form-control-sm" style="max-width: 25%;">
                        <label class="ml-2 mr-2" for="" style=" margin-left:1rem;">To</label>
                        <input type="date" id="d_to" class="form-control form-control-sm" style="max-width: 25%;">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" id="submit_date_exp">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                                
                    </div> -->
                
                    <!-- Moved Entire table to grid -> load_expenses KYLE 12-19-2023 -->
                <div class="" id="load_expenses">
                </div>
                 
<?php

if (!empty($expenses)) {
    $total_act = 0;
    $total_exp = 0;
    foreach ($expenses as $key => $value) {
          
            $total_act += $value->Actual_Money;
            $total_exp += $value->expense;
        ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= date('M d, Y', strtotime(@$value->Date)) ?></td>
                <td class="text-wrap"><?= ucfirst(@$value->Descr) ?></td>
                <td><?= @$value->FName." ".@$value->LName ?></td>
                <td><?= number_format(@$value->Actual_Money,2) ?></td>
                <td><?= number_format(@$value->expense,2) ?></td>
                <td><?= number_format(@$value->Balance,2) ?></td>
                <td>
                    <button class=" btn-primary btn-xs edit_exp" value="<?=$value->ID?>"><i class="fa fa-pencil-alt"></i></button>
                    <button class=" btn-success btn-xs clickable-row"  data-toggle="modal" data-target="#paymentProofModal" data-img="<?= $value->Image ?>"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-xs btn-danger btn_void_exp" value="<?=$value->ID?>">Void</button></td>
                </td>
            </tr>

        <?php
    } ?>

    <tr>                     
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-bold text-danger"><?= number_format(@$total_act,2)?></td>
        <td class="text-bold text-danger"><?= number_format(@$total_exp,2)?></td>
        <td class="text-bold text-danger"><?= number_format(@$total_act - $total_exp,2)?></td>
        <td></td>
    </tr>
<?php } else { ?>
    <tr>
        <td colspan="8">
            <div>
                <center>
                    <!-- <h6>No data available in table.</h6> -->
                </center>
            </div>
        </td>
    </tr>
<?php }
?>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="paymentProofModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proof Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span  class="close">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="image-container"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="toprint" style="display:none;"></div>
<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/expense/expense.js"></script>