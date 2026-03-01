
// Load Table Data
var load_items = () => {
  $(document).gmLoadPage({
    url: 'management/load_items',
    load_on: '#load_items'
  });
}

var load_items_deleted = () => {
  $(document).gmLoadPage({
    url: 'management/load_items_deleted',
    load_on: '#load_items_deleted'
  });
}

var load_supplier = () => {
  $(document).gmLoadPage({
    url: 'management/load_suppliers',
    load_on: '#load_suppliers'
  });
}

var load_units = () => {
  $(document).gmLoadPage({
    url: 'management/load_units',
    load_on: '#load_units'
  });
}

// Dynamic Drop Down Loading (No Page Refresh Required)
var load_items_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_items_drop_down',
    load_on: '#items_drop_down'
  });
}

var load_unit_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_unit_drop_down',
    load_on: '#unit_drop_down'
  });
}

var load_supplier_drop_down = () => {
  $(document).gmLoadPage({
    url: 'management/load_supplier_drop_down',
    load_on: '#supplier_drop_down'
  });
}

var load_user = () => {
  $(document).gmLoadPage({
    url: 'management/load_user',
    load_on: '#load_user'
  });
}

var load_buyers = () => {
  $(document).gmLoadPage({
    url: 'management/load_buyers',
    load_on: '#load_buyers'
  });
}

var load_clients = () => {
  $(document).gmLoadPage({
    url: 'management/load_clients',
    load_on: '#load_clients'
  });
}

$(document).ready(function () {
  load_items();
  load_user();
  load_supplier();
  load_units();
  load_clients();
  // load_items_deleted();
  
  load_items_drop_down();
  load_supplier_drop_down();
  load_unit_drop_down();
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  if (e.target.id === 'deleted-sub-tab') {
    load_items_deleted();
  }
  
});

// <<=========================================>>ITEM MANAGEMENT<<=========================================>>

$('#save_item').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save item details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          // Determine if this is a refreshment or medicine item based on category
          var category = $('#Category').val();
          var formData = {
            category: category,
          };

          if (category === 'Refreshment') {
            // Map refreshment fields to database columns
            // Brand Name (Item description label) → item_name column
            formData.item_name = $('#refreshment_item_name').val();
            // UOM → uom column
            formData.uom = $('#refreshment_uom').val();
            // Packaging (Net wt. / vol label) → packaging column
            formData.packaging = $('#refreshment_packaging').val();
            // Generic Name (Flavor/Variant label) → short_name column
            formData.short_name = $('#refreshment_generic_name').val();
            // Classification (Dept/Category label) → classification column
            formData.classification = $('#refreshment_classification').val();
            // Status
            formData.status = $('#refreshment_item_status').val();
            // Fields not used for refreshment
            formData.item_code = '';
            formData.description = '';
            formData.strenght = '';
            formData.storage_condition = '';
            formData.distributor = '';
            formData.pcs_stub = '';
            formData.pcs_box = '';
          } else {
            // Use medicine-specific fields
            formData.item_name = $('#item_name').val();
            formData.item_code = $('#code').val();
            formData.short_name = $('#short_name').val();
            formData.description = $('#item_description').val();
            formData.status = $('#item_status').val();
            formData.strenght = $('#strenght').val();
            formData.packaging = $('#packaging').val();
            formData.uom = $('#uom').val();
            formData.classification = $('#classification').val();
            formData.storage_condition = $('#storage_condition').val();
            formData.distributor = $('#distributor').val();
            formData.pcs_stub = $('#pcs_stub').val();
            formData.pcs_box = $('#pcs_box').val();
          }

          $.post({
            url: 'management/service/Management_service/save_list',
            data: formData,
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_items();
                load_items_drop_down();

                // Clear all fields
                $('#item_name').val("");
                $('#code').val("");
                $('#short_name').val("");
                $('#item_status').val("1");
                $('#item_description').val("");
                $('#Category').val("");
                $('#strenght').val("");
                $('#packaging').val("");
                $('#uom').val("");
                $('#classification').val("");
                $('#storage_condition').val("");
                $('#distributor').val("");
                $('#pcs_stub').val("");
                $('#pcs_box').val("");
                
                // Clear refreshment fields
                $('#refreshment_item_name').val("");
                $('#refreshment_generic_name').val("");
                $('#refreshment_packaging').val("");
                $('#refreshment_uom').val("");
                $('#refreshment_classification').val("");
                $('#refreshment_item_status').val("1");
                
                // Hide form sections
                $('#medicine').hide();
                $('#refreshment').hide();
                $('#update_item_2').show();
                $('#new').show();
                $('#save_item').hide();
                $('#cancel').hide();
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#update_item').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update item details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          // Determine if this is a refreshment or medicine item based on category
          var category = $('#Category').val();
          var formData = {
            id: $('#select_item').val(),
            category: category,
          };

          if (category === 'Refreshment') {
            // Map refreshment fields to database columns
            // Brand Name (Item description label) → item_name column
            formData.item_name = $('#refreshment_item_name').val();
            // UOM → uom column
            formData.uom = $('#refreshment_uom').val();
            // Packaging (Net wt. / vol label) → packaging column
            formData.packaging = $('#refreshment_packaging').val();
            // Generic Name (Flavor/Variant label) → short_name column
            formData.short_name = $('#refreshment_generic_name').val();
            // Classification (Dept/Category label) → classification column
            formData.classification = $('#refreshment_classification').val();
            // Status
            formData.status = $('#refreshment_item_status').val();
            // Fields not used for refreshment
            formData.item_code = '';
            formData.description = '';
            formData.strenght = '';
            formData.storage_condition = '';
            formData.distributor = '';
            formData.pcs_stub = '';
            formData.pcs_box = '';
          } else {
            // Use medicine-specific fields
            formData.item_name = $('#item_name').val();
            formData.item_code = $('#code').val();
            formData.short_name = $('#short_name').val();
            formData.description = $('#item_description').val();
            formData.status = $('#item_status').val();
            formData.strenght = $('#strenght').val();
            formData.packaging = $('#packaging').val();
            formData.uom = $('#uom').val();
            formData.classification = $('#classification').val();
            formData.storage_condition = $('#storage_condition').val();
            formData.distributor = $('#distributor').val();
            formData.pcs_stub = $('#pcs_stub').val();
            formData.pcs_box = $('#pcs_box').val();
          }

          $.post({
            url: 'management/service/Management_service/update_item',
            data: formData,
            success: function (e) {
              var e = JSON.parse(e);
              if (e.has_error == false) {
                toastr.success(e.message);
                load_items();
                load_items_drop_down();

                $('#item_name').val("");
                $('#code').val("");
                $('#short_name').val("");
                $('#item_status').val("1");
                $('#item_description').val("");
                $('#Category').val("");
                $('#strenght').val("");
                $('#packaging').val("");
                $('#uom').val("");
                $('#classification').val("");
                $('#storage_condition').val("");
                $('#distributor').val("");
                $('#pcs_stub').val("");
                $('#pcs_box').val("");
                
                // Clear refreshment fields
                $('#refreshment_item_name').val("");
                $('#refreshment_generic_name').val("");
                $('#refreshment_packaging').val("");
                $('#refreshment_uom').val("");
                $('#refreshment_classification').val("");
                $('#refreshment_item_status').val("1");
                
                // Hide form sections
                $('#medicine').hide();
                $('#refreshment').hide();
                $('#update_item_2').show();
                $('#new').show();
                $('#update_item').hide();
                $('#cancel').hide();
                $('#delete_item').hide();
                
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          })
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#delete_item').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to delete this item?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/delete_item',
            data: {
              id: $('#select_item').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
              
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

var editItem = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#item_id').val(data.getAttribute('data-id'));

  $('#item_name').val(data.getAttribute('data-item_name'));
  $('#code').val(data.getAttribute('data-item_code'));
  $('#short_name').val(data.getAttribute('data-short_name'));
  $('#item_status').val(data.getAttribute('data-status'));
  $('#item_description').val(data.getAttribute('data-description'));
  $('#Category').val(data.getAttribute('data-category'));
  $('#strenght').val(data.getAttribute('data-strenght'));
  $('#packaging').val(data.getAttribute('data-packaging'));
  $('#uom').val(data.getAttribute('data-uom'));
  $('#classification').val(data.getAttribute('data-classification'));
  $('#storage_condition').val(data.getAttribute('data-storage_condition'));
  $('#distributor').val(data.getAttribute('data-distributor'));
  // $('#item_expiry_date').val(data.getAttribute('data-item_expiry_date'));
  // $('#batch_no').val(data.getAttribute('data-batch_no'));


  $('#save_item').hide();
  $('#update_item').show();
  $('#delete_item').show();
}


$('#select_item').change(function () {
  var selectedOption = $(this).find('option:selected');
  var category = selectedOption.data('category');

  // Get common data attributes
  var itemId = selectedOption.data('id');
  var itemName = selectedOption.data('item_name');
  var itemCode = selectedOption.data('item_code');
  var shortName = selectedOption.data('short_name');
  var status = selectedOption.data('status');
  var itemDescription = selectedOption.data('description');
  var strenght = selectedOption.data('strenght');
  var packaging = selectedOption.data('packaging');
  var uom = selectedOption.data('uom');
  var classification = selectedOption.data('classification');
  var storageCondition = selectedOption.data('storage_condition');
  var distributor = selectedOption.data('distributor');

  $('#item_id').val(itemId);

  if (category === 'Refreshment') {
    // Show refreshment section, hide medicine section
    $('#medicine').hide();
    $('#refreshment').show();
    $('#medicine input').attr('required', false);
    $('#medicine select').attr('required', false);
    $('#refreshment input').attr('required', true);
    $('#refreshment select').attr('required', true);

    // Populate refreshment fields
    // item_name → refreshment_item_name
    $('#refreshment_item_name').val(itemName);
    // short_name → refreshment_generic_name
    $('#refreshment_generic_name').val(shortName);
    // packaging → refreshment_packaging
    $('#refreshment_packaging').val(packaging);
    // uom → refreshment_uom
    $('#refreshment_uom').val(uom);
    // classification → refreshment_classification
    $('#refreshment_classification').val(classification);
    // status → refreshment_item_status
    $('#refreshment_item_status').val(status);
  } else {
    // Show medicine section, hide refreshment section
    $('#medicine').show();
    $('#refreshment').hide();
    $('#medicine input').attr('required', true);
    $('#medicine select').attr('required', true);
    $('#refreshment input').attr('required', false);
    $('#refreshment select').attr('required', false);

    // Populate medicine fields
    $('#item_name').val(itemName);
    $('#code').val(itemCode);
    $('#short_name').val(shortName);
    $('#item_status').val(status);
    $('#item_description').val(itemDescription);
    $('#strenght').val(strenght);
    $('#packaging').val(packaging);
    $('#uom').val(uom);
    $('#classification').val(classification);
    $('#storage_condition').val(storageCondition);
    $('#distributor').val(distributor);
  }

  $('#Category').val(category);

  $('#save_item').hide();
  $('#cancel').show();
  $('#update_item').show();
  $('#delete_item').show();
  $('#pcs_stub').val(selectedOption.data('pcs_stub'));
  $('#pcs_box').val(selectedOption.data('pcs_box'));

});

// <<=========================================>>UNIT MANAGEMENT<<=========================================>>

var deletUnit = (data) => {
  // alert(data.getAttribute('data-id'));
  $('#unit_id').val(data.getAttribute('data-id'));
  $('#unit').val(data.getAttribute('data-item_name'));

  $('#save_unit').hide();
  $('#delete_unit').show();
}

$('#save_unit').click(function () {
  // alert($('#unit').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save this unit?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_unit',
            data: {
              unit: $('#unit').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_units();
                load_unit_drop_down();

                $('#unit').val("");
                // setTimeout(function () {
                //   window.location.reload();
                // }, 2000);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#delete_unit').click(function () {
  // alert($('#unit').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to delete this unit?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/delete_unit',
            data: {
              id: $('#unit_id').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_units();
                load_unit_drop_down();

                $('#unit').val("");
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

// <<=========================================>>SUPPLIER MANAGEMENT<<=========================================>>

var editSupplier = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#supplier_id').val(data.getAttribute('data-id'));

  $('#supplier_name').val(data.getAttribute('data-supplier_name'));
  $('#supplier_address').val(data.getAttribute('data-address'));
  $('#contact_person').val(data.getAttribute('data-contact_person'));
  $('#cn_1').val(data.getAttribute('data-contact_number_1'));
  $('#cn_2').val(data.getAttribute('data-contact_number_2'));
  $('#supplier_email').val(data.getAttribute('data-email'));
  $('#supplier_status').val(data.getAttribute('data-active'));



  $('#save_supplier').hide();
  $('#update_supplier').show();
}

$('#save_supplier').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save supplier details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_supplier',
            data: {
              supplier_name: $('#supplier_name').val(),
              supplier_address: $('#supplier_address').val(),
              contact_person: $('#contact_person').val(),
              contact_number_1: $('#cn_1').val(),
              contact_number_2: $('#cn_2').val(),
              supplier_email: $('#supplier_email').val(),
              supplier_status: $('#supplier_status').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_supplier();
                load_supplier_drop_down();

                $('#supplier_name').val("");
                $('#supplier_address').val("");
                $('#contact_person').val("");
                $('#cn_1').val("");
                $('#cn_2').val("");
                $('#supplier_email').val("");
                $('#supplier_status').val("1");

                // setTimeout(function () {
                //   window.location.reload();
                // }, 2000);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

$('#update_supplier').click(function () {
  // alert($('#supplier_id').val());
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update supplier details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/update_supplier',
            data: {
              id: $('#supplier_id').val(),
              supplier_name: $('#supplier_name').val(),
              supplier_address: $('#supplier_address').val(),
              contact_person: $('#contact_person').val(),
              contact_number_1: $('#cn_1').val(),
              contact_number_2: $('#cn_2').val(),
              supplier_email: $('#supplier_email').val(),
              supplier_status: $('#supplier_status').val(),
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
                load_supplier();
                load_supplier_drop_down();

                $('#supplier_name').val("");
                $('#supplier_address').val("");
                $('#contact_person').val("");
                $('#cn_1').val("");
                $('#cn_2').val("");
                $('#supplier_email').val("");
                $('#supplier_status').val("1");
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                $('#List').attr('class', 'form-control inpt is-invalid');
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});

// <<=========================================>>USER MANAGEMENT<<=========================================>>
let global_user_id = null;
// var editFunction = (x) => {
//   global_user_id = x;
//   $.post({
//     url: 'management/get_user_details',
//     // selector: '.form-control',
//     data: {
//       user_id: x,
//     },
//     success: function (e) {
//       var e = JSON.parse(e);
//       $('#LName').val(e.LName);
//       $('#FName').val(e.FName);
//       $('#UName').val(e.Username);
//       $('#Role').val(e.Role);
//       // $('#Branch').val(e.Branch);
//       $('#Update').val(e.U_ID);
//       $('#delete_user').val(e.U_ID);
//       $('#Reset').val(e.U_ID);

//       $('#Save').css('display', 'none');
//       $('#Update').css('display', 'inline');
//       $('#Reset').css('display', 'inline');
//       $('#Delete').css('display', 'inline');
//     },
//   })
// }

var editFunction = (x, row) => {
    global_user_id = x;

    // 🔹 Highlight selected row
    $('#userTable tbody tr').removeClass('selected');
    $(row).addClass('selected');

    $.post({
        url: 'management/get_user_details',
        data: {
            user_id: x,
        },
        success: function (e) {
            var e = JSON.parse(e);

            $('#LName').val(e.LName);
            $('#FName').val(e.FName);
            $('#UName').val(e.Username);
            $('#Role').val(e.Role);

            $('#Update').val(e.U_ID);
            $('#delete_user').val(e.U_ID);
            $('#Reset').val(e.U_ID);

            $('#Save').hide();
            $('#Update, #Reset, #Delete').show();
        },
    });
}


// SAVE USER DETAILS
$('#save_user').click(function () {
  $.post({
    url: baseUrl + 'management/service/Management_service/save_user',
    // selector: '.form-control',
    data: {
      FName: $('#FName').val(),
      LName: $('#LName').val(),
      Username: $('#UName').val(),
      // Branch: $('#Branch').val(),
      Role: $('#Role').find(':selected').data('id'),
      Role_name: $('#Role').find(':selected').data('role')

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});

$('#Update').click(function () {
  // alert(global_user_id);

  $.post({
    url: 'service/Management_service/update_user',
    // selector: '.form-control',
    data: {
      user_id: global_user_id,
      FName: $('#FName').val(),
      LName: $('#LName').val(),
      Username: $('#UName').val(),
      // Branch: $('#Branch').val(),
      Role: $('#Role').find(':selected').data('id'),
      Role_name: $('#Role').find(':selected').data('role')

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});


$('#delete_user').click(function () {
  $.post({
    url: 'service/Management_service/delete_user',
    // selector: '.form-control',
    data: {
      U_ID: $(this).val(),

    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      }
    },
  })
});

$('#Reset').click(function () {
  $.post({
    url: baseUrl + 'management/service/Management_service/reset',
    // selector: '.form-control',
    data: {
      U_ID: $(this).val(),
    },
    success: function (e) {
      var e = JSON.parse(e);
      if (e.has_error == false) {
        $('#modal-default').modal('hide');
        toastr.success(e.message);
        load_user();
        setTimeout(function () {
          window.location.reload();
        }, 2000);

      } else {
        $('#LName').attr('class', 'form-control inpt is-invalid');
        $('#FName').attr('class', 'form-control inpt is-invalid');
        $('#UName').attr('class', 'form-control inpt is-invalid');
        $('#modal-default').modal('hide');
        toastr.error(e.message);
      }
    },
  })
});

// client management

// Save Client
$('#save_client').click(function () {
  // basic required-field check
  if ($.trim($('#client-name').val()) === '') {
    $('#client-name').addClass('is-invalid');
    return toastr.error('Client Name is required.');
  }

  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to save client details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/save_client',
            data: {
              client_name: $.trim($('#client-name').val()),
              client_company_aff: $.trim($('#client-company-aff').val()),
              contact_number: $.trim($('#client-cn').val()),
              client_email: $.trim($('#client-email').val()),
              client_status: $('#client_status').val(),
              client_lto: $('#client-lto').val()
            },
            success: function (res) {
              let e;
              try {
                e = (typeof res === 'object') ? res : JSON.parse(res);
              } catch (err) {
                toastr.error('Invalid server response.');
                return;
              }

              if (!e.has_error) {
                toastr.success(e.message);

                // try all probable refresh functions if present (won't throw if absent)
                // if (typeof load_supplier === 'function') load_supplier();
                // if (typeof load_suppliers === 'function') load_suppliers();
                if (typeof load_clients === 'function') load_clients();

                // reset form
                $('#client-name').val('').removeClass('is-invalid');
                $('#client-company-aff').val('');
                $('#client-cn').val('');
                $('#client-email').val('');
                $('#client_status').val('1');
                $('#client-lto').val('');

                // ensure buttons back to initial state
                $('#update_client').hide();
                $('#save_client').show();
              } else {
                $('#client-name').addClass('is-invalid');
                toastr.error(e.message);
              }
            },
            error: function () {
              toastr.error("Something went wrong while saving client.");
            }
          });
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {}
      }
    }
  });
});


// Update Client
$('#update_client').click(function () {
  // You need a hidden input #client_id for updating (e.g. <input type="hidden" id="client_id" />)
  // if ($('#client_id').length === 0 || $.trim($('#client_id').val()) === '') {
  //   return toastr.error('No client selected to update. Make sure #client_id exists and contains the record id.');
  // }

  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to update client details?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: 'management/service/Management_service/update_client',
            data: {
              id: $.trim($('#client_id').val()),
              client_name: $.trim($('#client-name').val()),
              client_company_aff: $.trim($('#client-company-aff').val()),
              contact_number: $.trim($('#client-cn').val()),
              client_email: $.trim($('#client-email').val()),
              client_status: $('#client_status').val(),
              client_lto: $('#client-lto').val()

            },
            success: function (res) {
              let e;
              try {
                e = (typeof res === 'object') ? res : JSON.parse(res);
              } catch (err) {
                toastr.error('Invalid server response.');
                return;
              }

              if (!e.has_error) {
                toastr.success(e.message);

                if (typeof load_clients === 'function') load_clients();
                // if (typeof load_client_dd === 'function') load_client_dd();

                // reset form
                $('#client-name').val('').removeClass('is-invalid');
                $('#client-company-aff').val('');
                $('#client-cn').val('');
                $('#client-email').val('');
                $('#client_status').val('1');
                $('#client-lto').val('');

                // optional: hide update button & show save button
                $('#update_client').hide();
                $('#save_client').show();

                // refresh the page shortly to ensure table state (matches your previous behavior)
                // setTimeout(function () {
                //   window.location.reload();
                // }, 500);
              } else {
                $('#client-name').addClass('is-invalid');
                toastr.error(e.message);
              }
            },
            error: function () {
              toastr.error("Something went wrong while updating client.");
            }
          });
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {}
      }
    }
  });
});

var editClient = (data) => {
  // console.log(data.getAttribute('data-id'));
  $('#client_id').val(data.getAttribute('data-id'));

  $('#client-name').val(data.getAttribute('data-name'));
  $('#client-company-aff').val(data.getAttribute('data-affiliate'));
  $('#client-cn').val(data.getAttribute('data-cnum'));
  $('#client-email').val(data.getAttribute('data-email'));
  $('#client_status').val(data.getAttribute('data-status'));
  $('#client-lto').val(data.getAttribute('data-lto'));

  $('#save_client').hide();
  $('#update_client').show();
}


let modifiedData = [];

$(document).on('change', '.role-checkbox', function () {
  const userId = $(this).data('user-id');
  const module = $(this).data('module');
  const isChecked = $(this).is(':checked');

  // Check if this user-module already exists in modifiedData
  const existingIndex = modifiedData.findIndex(
    item => item.user_id === userId && item.module === module
  );

  if (existingIndex !== -1) {
    // Update existing record
    modifiedData[existingIndex].granted = isChecked ? 1 : 0;
  } else {
    // Add new record
    modifiedData.push({
      user_id: userId,
      module: module,
      granted: isChecked ? 1 : 0
    });
  }
});

// Submit button click
$('#saveRbacBtn').on('click', function (e) {
  e.preventDefault();

  if (modifiedData.length === 0) {
    alert('No changes detected.');
    return;
  }
  console.log(modifiedData);

  $.ajax({
    url: "management/service/Management_service/save_rbac_access",
    type: 'POST',
    dataType: 'json',
    data: { user_access: JSON.stringify(modifiedData) },
    beforeSend: function () {
      $('#saveRbacBtn').prop('disabled', true).text('Saving...');
    },
    success: function (response) {
      let res = (typeof response === 'object') ? response : JSON.parse(response);

      if (res.success) {
        alert('RBAC updated successfully!');
        modifiedData = [];
      } else {
        alert('Error: ' + res.message);
      }

    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', error);
      alert('An error occurred while saving.');
    },
    complete: function () {
      $('#saveRbacBtn').prop('disabled', false).text('Submit');
    }
  });
});