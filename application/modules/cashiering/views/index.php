<?php
main_header(['cashiering']);
$session = (object) get_userdata(USER);

// var_dump($items);
?>
<style>
    body { background: #f9f9f9; }
    .card {
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      position: relative;
      height: 180px;
    }
    .stock-label {
      background: #eafaf1;
      color: #2a9d47;
      font-size: 12px;
      padding: 3px 8px;
      border-radius: 20px;
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .stock-low { background: #fff3cd; color: #856404; }
    .btn-add {
      background: #035863;
      color: #fff;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      bottom: 10px;
      right: 10px;
    }
    .btn-add:hover { background: #035863; }
    .cart-panel {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .cart-header { font-size: 18px; font-weight: bold; }
    .cart-item { border-bottom: 1px solid #eee; padding: 10px 0; }
    .cart-total { font-weight: bold; font-size: 18px; }
    .btn-checkout {
      width: 100%;
      background: #035863;
      color: #fff;
      font-size: 16px;
      margin-top: 15px;
    }
    .btn-checkout:hover { background: #035863; }
    .cart-item .btn {
  width: 32px;
  height: 32px;
  padding: 0;
}

    
  </style>
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
    <div class="container-fluid">
        <div class="row">
            <!-- Left side: Products -->
            <div class="col-lg-8 col-md-7 col-sm-12" style="background-color: white;">
                
                <!-- Search Box -->
                <div class="row mt-3">
                    <div class="col-12">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2 w-100" type="search" placeholder="Search products..." aria-label="Search" id="productSearch">
                        </form>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="row mt-3" id="productList">
                    <?php foreach($items as $item => $i){ ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 product-card">
                        <div class="card p-3">
                            <small class="card-text text-muted mb-1"><?=strtoupper($i->Category)?></small>
                            <h6 class="card-title mb-1"><?=$i->item_name?></h6>
                            <span class="stock-label">Stock: <?=$i->current_stock?></span>
                            <p class="card-text text-muted mb-1"><?=$i->description?></p>
                            <small class="card-text text-muted mb-1"><?=$i->item_code?></small>
                            <div class="font-weight-bold">₱<?=$i->unit_price?></div>
                            <!-- Add data attributes so JS can grab item info -->
                            <button class="btn btn-add" 
                                    data-name="<?=$i->item_name?>" 
                                    data-price="<?=$i->unit_price?>"
                                    data-item_profile_id="<?=$i->item_profile_id?>">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Right side: Cart -->
            <div class="col-lg-4 col-md-5 col-sm-12">
                <div class="cart-panel">
                    <div class="cart-header">
                        Current Sale <a href="#" id="clear-cart" class="float-right text-danger">Clear All</a>
                    </div>

                    <!-- Cart items will load here -->
                    <div id="cart-items"></div>

                    <hr>
                  
                    <p class="cart-total">Buyer: 
                        <span class="float-right">
                          <select name="" id="Buyer_id" class="form-control form-control-sm"  style="width: 200px;" >
                                <option value="" disabled selected>-- Select Buyer --</option>
                                <?php
                                    foreach($buyers as $b){ ?>
                                        <option value="<?= $b->ID ?>"><?= ucfirst($b->FName)?></option>

                                <?php   }
                                ?>
                                <option value="1">WALKIN</option>
                                <option value="0">OTHERS</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="other_buyer"  style="width: 200px;" placeholder="Enter buyer..." hidden>
                        </span>
                    </p>
                    <p class="cart-total mt-5">Discount: <span class="float-right"><input type="number" class="form-control form-control-sm" id="total_discounts"  style="width: 200px;"  placeholder="Enter discount..." ></span></p>
                    <p class="cart-total">Total: <span class="float-right" id="total">₱0.00</span></p>
                    <button class="btn btn-checkout" id="tend_customer">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>
</section>

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
<script src="<?php echo base_url() ?>/assets/js/cashiering/cashiering.js"></script>
<script>
  let cart = [];

function renderCart() {
  let cartItemsDiv = document.getElementById("cart-items");
  let total = 0;

  cartItemsDiv.innerHTML = cart.map((item, i) => {
    let itemTotal = item.qty * item.price;
    total += itemTotal;

    return `
      <div class="cart-item mb-3 pb-2 border-bottom" data-index="${i}"  data-item_profile_id="${item.item_profile_id}">
        <div><strong>${item.name}</strong></div>
         <input type="text" hidden value="${item.item_profile_id}">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            ₱${item.price.toLocaleString("en-PH", {minimumFractionDigits:2})} each
          </div>
          <div class="d-flex align-items-center">
            <button class="btn btn-sm btn-outline-secondary minus">-</button>
            <input type="number" class="form-control form-control-sm text-center mx-1 qty" 
                   value="${item.qty}" min="1" style="width:60px;">
            <button class="btn btn-sm btn-outline-secondary plus">+</button>
          </div>
        </div>

        <div class="text-right mt-1">= ₱${itemTotal.toLocaleString("en-PH", {minimumFractionDigits:2})}</div>
      </div>
    `;
  }).join("");

  document.getElementById("total").innerText =
    "₱" + total.toLocaleString("en-PH", {minimumFractionDigits:2});
}



// Handle cart actions with one listener
document.getElementById("cart-items").addEventListener("click", e => {
  let parent = e.target.closest(".cart-item");
  if (!parent) return;
  let index = parent.dataset.index;

  if (e.target.classList.contains("plus")) cart[index].qty++;
  if (e.target.classList.contains("minus")) {
    cart[index].qty > 1 ? cart[index].qty-- : cart.splice(index, 1);
  }
  renderCart();
});

// Handle manual input
document.getElementById("cart-items").addEventListener("change", e => {
  if (!e.target.classList.contains("qty")) return;
  let index = e.target.closest(".cart-item").dataset.index;
  cart[index].qty = Math.max(1, parseInt(e.target.value) || 1);
  renderCart();
});

// Example: add item
document.querySelectorAll(".btn-add").forEach(btn => {
  btn.addEventListener("click", () => {
    let name = btn.dataset.name;
    let price = parseFloat(btn.dataset.price);
    let item_profile_id = btn.dataset.item_profile_id;
    let existing = cart.find(i => i.item_profile_id === item_profile_id);
    

    existing ? existing.qty++ :  cart.push({ item_profile_id, name, price, qty: 1 });
    renderCart();
  });
});

document.getElementById("clear-cart").addEventListener("click", e => {
  e.preventDefault();
  cart = [];
  renderCart();
});

$("#productSearch").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".product-card").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
    currentPage = 1; // reset to first page when searching
    showPage(currentPage);
});

$("#Buyer_id").on("change", function () {
    if(($(this).val() == 0)){
        $('#other_buyer').removeAttr('hidden');
    }else{
        $('#other_buyer').attr('hidden', 'true');
    }
});
</script>
